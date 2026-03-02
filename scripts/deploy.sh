#!/bin/bash
set -e

# Ensure storage and bootstrap/cache are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "DATABASE CONFIGS (DEBUG):"
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"

if [ -z "$DB_HOST" ] && [ -z "$DB_URL" ]; then
    echo "CRITICAL: No database host or URL found in environment!"
fi

# Clear existing configuration caches
php artisan config:clear

# Neon SNI workaround: explicitly set the endpoint ID
export PGOPTIONS="-c endpoint=ep-snowy-butterfly-aive3zr8"

# Run migrations. We already seeded locally, so just ensure schema is up to date.
php artisan migrate --force

# Re-optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground
apache2-foreground
