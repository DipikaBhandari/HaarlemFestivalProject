FROM php:fpm

RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer