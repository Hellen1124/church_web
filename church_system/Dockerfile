# --- Stage 1: Builder ---
FROM php:8.2-fpm-alpine AS builder

# Install the PHP Extension Installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install PHP extensions required for Laravel & Postgres
RUN install-php-extensions pdo pdo_pgsql mbstring exif pcntl gd zip intl bcmath opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code
COPY . .

# Remove .env files
RUN rm -f .env .env.example || true

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction \
    && php artisan config:cache \
    && php artisan route:cache

# --- Stage 2: Final Runtime ---
FROM php:8.2-fpm-alpine

# Install the PHP Extension Installer again for the runtime stage
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# ⭐⭐⭐ INSTALL PHP-FPM & NGINX & SUPERVISOR ⭐⭐⭐
RUN apk add --no-cache nginx supervisor curl postgresql-client \
    && install-php-extensions pdo pdo_pgsql mbstring exif pcntl gd zip intl bcmath opcache

# Configure PHP-FPM
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/;clear_env = no/clear_env = no/g' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/listen = 127.0.0.1:9000/listen = 127.0.0.1:9000/g' /usr/local/etc/php-fpm.d/www.conf

# Copy application from builder
COPY --from=builder /var/www/html /var/www/html

# Remove any .env files that might have been copied
RUN rm -f /var/www/html/.env /var/www/html/.env.example 2>/dev/null || true

# Setup permissions
RUN addgroup -g 1000 -S www-data && \
    adduser -u 1000 -S www-data -G www-data && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage directories
RUN mkdir -p /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
    && chown -R www-data:www-data /var/www/html/storage

# Configure Nginx & Supervisor
COPY nginx/default.conf /etc/nginx/http.d/default.conf
RUN mkdir -p /etc/supervisor/conf.d
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Create the supervisor log directory
RUN mkdir -p /var/log/supervisor && chown -R www-data:www-data /var/log/supervisor

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:8080/health || exit 1

EXPOSE 8080

CMD ["/start.sh"]