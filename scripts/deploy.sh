#!/bin/bash
set -e

# Ensure storage and bootstrap/cache are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "Connecting to database host: $DB_HOST"

# Clear existing caches to ensure fresh env variables are loaded
php artisan config:clear
php artisan cache:clear

echo "Connecting to database host: $DB_HOST"
if [ -z "$DB_HOST" ]; then
    echo "Using DB_URL from environment"
fi

# Run migrations. Using :fresh for initial setup to clear any partial tables.
# Once the site is live, we will change this back to 'migrate --force'.
php artisan migrate:fresh --force --seed

# Re-optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in the foreground
apache2-foreground
