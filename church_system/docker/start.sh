#!/bin/sh

# Exit on any error
set -e

echo "🚀 Setting up Laravel application on Render..."

# 1. ENSURE PERMISSIONS EXIST FIRST
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 2. CLEAR CACHE BEFORE DOING ANYTHING
# We use --force and explicitly tell it to use the pgsql connection 
# to prevent it from looking for a sqlite file.
php artisan config:clear
php artisan cache:clear

# 3. RUN MIGRATIONS
echo "📦 Running database migrations..."
# The --force is required for production
php artisan migrate --force --no-interaction

# 4. OPTIMIZE FOR PRODUCTION
echo "⚡ Optimizing configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🎬 Starting Web Server..."
# Using the standard command for this specific image
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf