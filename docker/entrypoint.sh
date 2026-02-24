#!/bin/bash
set -e

echo "Starting JussiLog Backend..."

# Get port from environment (Cloud Run sets this, default to 8080)
PORT="${PORT:-8080}"
echo "Using port: $PORT"

# Update Nginx configuration with the correct port
sed -i "s/listen 8080/listen $PORT/g" /etc/nginx/http.d/default.conf
sed -i "s/listen \[::\]:8080/listen \[::\]:$PORT/g" /etc/nginx/http.d/default.conf

# Ensure database directory exists
mkdir -p /var/www/html/database

# Fix permissions for bind-mounted directories (local development)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database || true

# Create SQLite database file if it doesn't exist
if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "Creating SQLite database file..."
    touch /var/www/html/database/database.sqlite
    chmod 664 /var/www/html/database/database.sqlite
fi

# Wait a moment for filesystem to be ready
sleep 1

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Create storage link if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link || true
fi

# Production optimizations (skip in local development)
if [ "$APP_ENV" != "local" ]; then
    echo "Running production optimizations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    echo "Local development mode - skipping cache optimizations"
    php artisan config:clear || true
fi

# Ensure proper permissions
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod 664 /var/www/html/database/database.sqlite

echo "Starting PHP-FPM..."
# Start PHP-FPM in background
php-fpm -D

echo "Starting Nginx on port $PORT..."
# Start Nginx in foreground (keeps container running)
exec nginx -g 'daemon off;'
