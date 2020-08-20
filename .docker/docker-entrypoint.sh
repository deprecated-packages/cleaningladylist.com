#!/bin/bash
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- apache2-foreground "$@"
fi

if [ "$1" = 'apache2-foreground' ] || [ "$1" = 'bin/console' ] || [ "$1" = 'php' ] || [ "$1" = 'composer' ]; then
    if [ "$APP_ENV" != 'prod' ]; then
        composer install --prefer-dist --no-progress --no-suggest --no-interaction -o
    fi

    php bin/console assets:install
    php bin/console cache:clear

    ## Wait until database connection is ready
    # @todo if sleep is not enough add custom "bin/console check:database" that already knows the databse exists

    ## Update DB - broken for now: https://github.com/rectorphp/cleaningladylist.com/runs/1007822678
    # possibly add to run.sh script on the server
    # sleep 5
    # php bin/console doctrine:schema:update --dump-sql --force

    ## Create DB
    # can be repalced in docker-compose MYSQL_DATABAE
    # php bin/console doctrine:database:create --if-not-exists

    ## Update DB
    # php bin/console doctrine:schema:update --dump-sql --force

    # Permissions hack because setfacl does not work on Mac and Windows
    chown -R www-data var
fi

exec "$@"
