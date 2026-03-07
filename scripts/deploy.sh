#!/usr/bin/env bash
set -euo pipefail

# Ensure storage and bootstrap/cache are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Render expects web services to bind to an externally reachable port.
APP_PORT="${PORT:-10000}"
echo "Configuring Apache to listen on 0.0.0.0:${APP_PORT}"

# Force IPv4 binding and set ServerName to suppress warnings
if ! grep -q "^ServerName " /etc/apache2/apache2.conf; then
    echo "ServerName localhost" >> /etc/apache2/apache2.conf
fi
sed -ri "s/^Listen[[:space:]]+80$/Listen 0.0.0.0:${APP_PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${APP_PORT}>/" /etc/apache2/sites-available/000-default.conf

echo "ENVIRONMENT AUDIT:"
echo "DB_CONNECTION: ${DB_CONNECTION:-<unset>}"
if [ -n "${DB_URL:-}" ]; then
    echo "DB_URL is PRESENT (masked)"
else
    echo "DB_URL is MISSING"
fi
echo "DB_HOST: ${DB_HOST:-<unset>} (should be empty if using DB_URL)"

# Clear existing configuration caches
php artisan config:clear

# Run migrations with retries to avoid restart loops when DB is still booting.
MIGRATION_MAX_ATTEMPTS="${MIGRATION_MAX_ATTEMPTS:-15}"
MIGRATION_RETRY_SLEEP_SECONDS="${MIGRATION_RETRY_SLEEP_SECONDS:-4}"
attempt=1
until php artisan migrate --force; do
    if [ "$attempt" -ge "$MIGRATION_MAX_ATTEMPTS" ]; then
        echo "Migration failed after ${MIGRATION_MAX_ATTEMPTS} attempts."
        exit 1
    fi
    echo "Migration attempt ${attempt}/${MIGRATION_MAX_ATTEMPTS} failed. Retrying in ${MIGRATION_RETRY_SLEEP_SECONDS}s..."
    attempt=$((attempt + 1))
    sleep "${MIGRATION_RETRY_SLEEP_SECONDS}"
done

# Re-optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground
exec apache2-foreground
