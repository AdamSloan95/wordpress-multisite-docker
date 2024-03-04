FROM php:7.4-fpm-alpine
#install and enable pdo
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql