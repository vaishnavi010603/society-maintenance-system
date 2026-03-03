FROM docker.io/library/php:8.2-apache

RUN apt-get update && \
    apt-get install -y zip unzip libzip-dev && \
    docker-php-ext-install zip

WORKDIR /var/www/html

COPY web/ /var/www/html/
COPY data/ /var/www/html/data/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
