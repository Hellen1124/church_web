#!/bin/sh

# Run migrations (Optional: remove if you want to run manually)
# php artisan migrate --force

# Start Supervisor
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf