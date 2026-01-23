#!/bin/sh
set -e

echo "🚀 FINAL ATTEMPT: Clearing everything and rebuilding..."

# 1. Folders & Permissions
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 2. REBUILD DATABASE
# migrate:fresh will use our new file order to build everything perfectly
echo "📦 Running migrate:fresh..."
php artisan migrate:fresh --force --no-interaction

# 3. OPTIMIZE
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🎬 SUCCESS! Starting server..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf