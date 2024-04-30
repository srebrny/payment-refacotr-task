FROM php:8.3-cli

# New user, add to group add to www-data
#USER app

RUN apt-get update && apt-get install -y git tig nano zip
RUN pecl install \
        pcov && \
    docker-php-ext-enable \
        pcov && \
    rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "pcov.directory = /app" >> /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Files and workdir
COPY ./app /app
WORKDIR /app
