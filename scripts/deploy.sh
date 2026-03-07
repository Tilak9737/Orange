#!/bin/bash
set -e

# Ensure storage and bootstrap/cache are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "ENVIRONMENT AUDIT:"
echo "DB_CONNECTION: $DB_CONNECTION"
if [ -n "$DB_URL" ]; then
    echo "DB_URL is PRESENT (masked)"
else
    echo "DB_URL is MISSING"
fi
echo "DB_HOST: $DB_HOST (should be empty if using DB_URL)"

# Clear existing configuration caches
php artisan config:clear

# Run migrations. We already seeded locally, so just ensure schema is up to date.
php artisan migrate --force

# Re-optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground
apache2-foreground
