#!/bin/bash
DIR=$(pwd);

php $DIR/bin/console doctrine:database:create --env=test --if-not-exists;

php $DIR/bin/console doctrine:schema:drop --env=test --full-database --force;

php $DIR/bin/console doctrine:migrations:migrate --env=test --no-interaction;
php $DIR/bin/console doctrine:fixtures:load --env=test --no-interaction;

php $DIR/bin/phpunit;
