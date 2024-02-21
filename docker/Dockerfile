FROM php:8.3-fpm

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache

RUN apt update
RUN apt install zip -y

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
