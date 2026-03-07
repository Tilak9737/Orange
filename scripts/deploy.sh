#!/bin/bash
set -e

# Ensure storage and bootstrap/cache are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Configure Apache to listen on the PORT environment variable
if [ -n "$PORT" ]; then
    echo "Configuring Apache to listen on port 0.0.0.0:$PORT"
    # Force IPv4 binding and set ServerName to suppress warnings
    echo "ServerName localhost" >> /etc/apache2/apache2.conf
    sed -i "s/Listen 80/Listen 0.0.0.0:${PORT}/g" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf
fi

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
