#!/bin/sh
set -e

echo "Starting JussiLog Backend..."

# Get port from environment (Cloud Run sets this, default to 8080)
PORT="${PORT:-8080}"
echo "Using port: $PORT"

# Update Nginx configuration with the correct port
sed -i "s/listen 8080/listen $PORT/g" /etc/nginx/http.d/default.conf
sed -i "s/listen \[::\]:8080/listen \[::\]:$PORT/g" /etc/nginx/http.d/default.conf

# Ensure storage and cache directories exist and have proper permissions
mkdir -p /var/www/html/storage/framework/cache \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Fix ownership and permissions for bind-mounted directories
# This ensures the laravel user can write to these directories
chown -R laravel:laravel /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Get database connection type
DB_CONNECTION="${DB_CONNECTION:-mysql}"
echo "Database connection: $DB_CONNECTION"

# Handle database-specific setup
if [ "$DB_CONNECTION" = "sqlite" ]; then
    echo "Setting up SQLite database..."
    
    # Ensure database directory exists
    mkdir -p /var/www/html/database
    
    # Create SQLite database file if it doesn't exist
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        echo "Creating SQLite database file..."
        touch /var/www/html/database/database.sqlite
        chown laravel:laravel /var/www/html/database/database.sqlite
        chmod 664 /var/www/html/database/database.sqlite
    fi
    
    # Fix ownership and permissions for SQLite database
    chown laravel:laravel /var/www/html/database /var/www/html/database/database.sqlite 2>/dev/null || true
    chmod -R 775 /var/www/html/database 2>/dev/null || true

elif [ "$DB_CONNECTION" = "mysql" ]; then
    echo "Setting up MySQL database..."
    
    # Wait for MySQL to be ready
    DB_HOST="${DB_HOST:-127.0.0.1}"
    DB_SOCKET="${DB_SOCKET:-}"
    DB_PORT="${DB_PORT:-3306}"
    DB_DATABASE="${DB_DATABASE:-jussilog}"
    DB_USERNAME="${DB_USERNAME:-jussilog}"
    DB_PASSWORD="${DB_PASSWORD:-jussilog}"
    
    # Determine connection method
    if [ -n "$DB_SOCKET" ]; then
        # Unix socket connection (Cloud SQL)
        echo "Connecting via Unix socket: $DB_SOCKET"
        MYSQL_CONN_ARGS="--socket=$DB_SOCKET"
        CONNECTION_DESC="Unix socket $DB_SOCKET"
    else
        # TCP connection (local/Docker)
        echo "Connecting via TCP: $DB_HOST:$DB_PORT"
        MYSQL_CONN_ARGS="-h $DB_HOST -P $DB_PORT --ssl=0"
        CONNECTION_DESC="$DB_HOST:$DB_PORT"
    fi
    
    echo "Waiting for MySQL at $CONNECTION_DESC..."
    
    # Try to connect to MySQL with retries
    MAX_RETRIES=30
    RETRY_COUNT=0
    
    while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
        # Try mysqladmin ping
        if mysqladmin ping $MYSQL_CONN_ARGS -u "$DB_USERNAME" -p"$DB_PASSWORD" --silent 2>/dev/null; then
            echo "MySQL is ready!"
            break
        fi
        
        # If mysqladmin fails, try with mysql client
        if mysql $MYSQL_CONN_ARGS -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; then
            echo "MySQL is ready!"
            break
        fi
        
        RETRY_COUNT=$((RETRY_COUNT + 1))
        echo "Waiting for MySQL... ($RETRY_COUNT/$MAX_RETRIES)"
        sleep 2
    done
    
    if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
        echo "ERROR: Could not connect to MySQL after $MAX_RETRIES attempts"
        echo "Connection details: $CONNECTION_DESC"
        echo "Username: $DB_USERNAME"
        exit 1
    fi
    
    # Create database if it doesn't exist
    echo "Ensuring database $DB_DATABASE exists..."
    mysql $MYSQL_CONN_ARGS -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS \`$DB_DATABASE\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || true
    echo "Database ready!"
fi

# Wait a moment for filesystem to be ready
sleep 1

# Run database migrations as laravel user
echo "Running database migrations..."
su laravel -s /bin/sh -c "php artisan migrate --force --no-interaction"

# Create storage link if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage link..."
    su laravel -s /bin/sh -c "php artisan storage:link" || true
fi

# Production optimizations (skip in local development)
if [ "$APP_ENV" != "local" ]; then
    echo "Running production optimizations..."
    su laravel -s /bin/sh -c "php artisan config:cache"
    su laravel -s /bin/sh -c "php artisan route:cache"
    su laravel -s /bin/sh -c "php artisan view:cache"
else
    echo "Local development mode - skipping cache optimizations"
    # Ensure route/config/view caches never mask live code changes in local dev.
    su laravel -s /bin/sh -c "php artisan optimize:clear" || true
fi

echo "Starting PHP-FPM..."
# Start PHP-FPM in background
php-fpm -D

echo "Starting Nginx on port $PORT..."
# Start Nginx in foreground (keeps container running)
exec nginx -g 'daemon off;'

