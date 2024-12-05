# Use the official PHP 8.2 CLI image as the base image
FROM php:8.2-cli

# Set the working directory inside the container to /app
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

# Install system dependencies for PHP extensions and PECL modules
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer globally in the container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Run Composer to install the PHP dependencies defined in your composer.json file
RUN composer install

# Keep the container running
CMD ["tail", "-f", "/dev/null"]
