#!/bin/sh

# Exit on any error
set -e

echo "🚀 Setting up Laravel application..."

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create necessary directories
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Check if migrations have been run (free tier safe)
if [ ! -f /var/www/html/storage/framework/migrations_ran ]; then
    echo "📦 Running database migrations..."
    php artisan migrate --force --no-interaction
    touch /var/www/html/storage/framework/migrations_ran
    echo "✅ Migrations completed!"
else
    echo "⏩ Migrations already run, skipping..."
fi

# Generate key if not set (safety check)
php artisan key:generate --no-interaction --force 2>/dev/null || true

echo "🎬 Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf