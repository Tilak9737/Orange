#!/bin/bash
set -e

# Ensure storage and bootstrap/cache are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Connecting to database host: $DB_HOST"

# Clear existing configuration caches
php artisan config:clear

echo "Connecting to database host: $DB_HOST"
if [ -z "$DB_HOST" ]; then
    echo "Using DB_URL from environment"
fi

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
