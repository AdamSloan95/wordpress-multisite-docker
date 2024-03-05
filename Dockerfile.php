FROM php:7.4-fpm-alpine

#install and enable pdo
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Get the WP CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

# Change permission and move
RUN chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp