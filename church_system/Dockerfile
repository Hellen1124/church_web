FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache curl git postgresql-dev nginx supervisor \
    libpng-dev libzip-dev icu-dev oniguruma-dev freetype-dev libjpeg-turbo-dev

# Install PHP extensions (all that Laravel needs)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_pgsql bcmath mbstring exif pcntl gd zip intl

# Enable PHP extensions
RUN docker-php-ext-enable opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code
COPY . .

# Remove .env files
RUN rm -f .env .env.example || true

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Setup permissions
RUN addgroup -g 1000 -S www-data && \
    adduser -u 1000 -S www-data -G www-data && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy configuration files
COPY nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]