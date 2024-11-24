# Stage 1: Build Stage
FROM php:8.3-fpm-alpine

# Set the working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    zip \
    libzip-dev \
    nginx \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

# Copy composer files first (to optimize caching)
COPY . .

# Set permissions for Laravel folders
RUN chown -R www-data:www-data /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --prefer-dist

RUN chown -R www-data:www-data /var/www/html/vendor \
    && chmod -R 775 /var/www/html/vendor

# Copy necessary files from the build stage
COPY ./nginx.conf /etc/nginx/http.d/default.conf

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]
