# inspiration: https://github.com/rectorphp/getrector.org/blob/master/Dockerfile

## This build contains only prepared environment, without sorce codes
FROM php:7.4-apache as dev

LABEL maintainer="Jan Mikeš <j.mikes@me.com>"

WORKDIR /var/www/cleaningladylist.com

# Apache config
COPY ./.docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Setup package manage repositories for nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

# Install nodejs + php extensions
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        g++ \
        default-mysql-client \
        zlib1g-dev \
        libicu-dev \
        libzip-dev \
        nodejs \
    && docker-php-ext-install pdo_mysql \
    && pecl -q install \
        zip \
    && docker-php-ext-enable zip

# Install yarn
RUN npm install -g yarn

# Installing composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1

# Entrypoint
# standard location from parent image "php:7.4-apache as base": https://github.com/docker-library/php/blob/098e442542e8a10bdee2c22484a98d41583a8fb9/7.4/buster/apache/Dockerfile#L273
COPY ./.docker/docker-php-entrypoint \
    ./.docker/docker-dev-php-entrypoint \
    ./.docker/docker-dev-js-entrypoint \
    /usr/local/bin/

# this is always run "docker run/docker-compose ..."
RUN chmod 777 /usr/local/bin/docker-*

# COPY ./.docker/docker-dev-js-entrypoint /usr/local/bin/docker-php-entrypoint
# COPY ./.docker/docker-dev-php-entrypoint /usr/local/bin/docker-php-entrypoint


####
## Build app itself - containing source codes and is designed to leverage Docker layers caching
####
FROM dev as production

RUN mkdir -p ./var/cache ./var/log
RUN chown -R www-data ./var

# Install npm packages
COPY package.json yarn.* webpack.config.js ./
RUN yarn install

# Production yarn build
COPY ./assets ./assets
RUN yarn run build

# Install composer packages
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest \
    && composer clear-cache
RUN composer dump-autoload -o --no-dev

COPY . .
