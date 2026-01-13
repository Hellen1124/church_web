# --- Stage 1: Builder ---
FROM php:8.2-fpm-alpine AS builder

# Install the PHP Extension Installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install PHP extensions required for Laravel & Postgres
RUN install-php-extensions pdo pdo_pgsql mbstring exif pcntl gd zip intl bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# --- Stage 2: Final Runtime ---
FROM php:8.2-fpm-alpine

# Install the PHP Extension Installer again for the runtime stage
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install Runtime Dependencies (Nginx, Supervisor, and PHP extensions)
RUN apk add --no-cache nginx supervisor shadow curl \
    && install-php-extensions pdo pdo_pgsql mbstring exif pcntl gd zip intl bcmath

# Copy application from builder
COPY --from=builder /var/www/html /var/www/html

# Setup permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Nginx & Supervisor
COPY nginx/default.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /etc/supervisor/conf.d
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Fix for storage directories
RUN mkdir -p /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    && chown -R www-data:www-data /var/www/html/storage

EXPOSE 8080

HEALTHCHECK --interval=30s --timeout=3s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:8080 || exit 1

CMD ["/start.sh"]