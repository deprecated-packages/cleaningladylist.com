# inspiration: https://github.com/rectorphp/getrector.org/blob/master/Dockerfile

## This build stage contains only prepared environment, without sorce codes
FROM php:7.4-apache as dev

LABEL maintainer="Jan Mikeš <j.mikes@me.com>"

WORKDIR /var/www/cleaningladylist.com

# Apache config
COPY ./.docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Install nodejs + php extensions
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        g++ \
        default-mysql-client \
        zlib1g-dev \
        libicu-dev \
        libzip-dev \
    && docker-php-ext-install pdo_mysql \
    && pecl -q install \
        zip \
    && docker-php-ext-enable zip

# Installing composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1

# Entrypoint
# standard location from parent image "php:7.4-apache as base": https://github.com/docker-library/php/blob/098e442542e8a10bdee2c22484a98d41583a8fb9/7.4/buster/apache/Dockerfile#L273
COPY ./.docker/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint
COPY ./.docker/docker-dev-php-entrypoint /usr/local/bin/docker-dev-php-entrypoint

# this is always run "docker run/docker-compose ..."
RUN chmod 777 /usr/local/bin/docker-*entrypoint


####
## Build frontend assets
####
FROM node:14-alpine as js-builder

WORKDIR /build

# Install npm packages
COPY package.json yarn.* webpack.config.js ./
RUN yarn install

# Production yarn build
COPY ./assets ./assets
RUN yarn run build


####
## Build app itself - containing source codes and is designed to leverage Docker layers caching
####
FROM dev as production

RUN mkdir -p ./var/cache ./var/log
RUN chmod -R 777 ./var

COPY --from=js-builder /build/public ./public

# Install composer packages
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest
RUN composer dump-autoload --optimize --no-dev

COPY . .
