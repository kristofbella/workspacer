FROM php:8.2.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    openssl \
    && docker-php-ext-install zip \
    && docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --from=composer:2.5.4 /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/www/api
RUN chown -R www-data:www-data /var/www/api