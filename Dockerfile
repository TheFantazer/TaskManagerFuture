FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite
