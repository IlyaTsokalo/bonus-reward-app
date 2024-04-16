#!/bin/sh
set -e

if php bin/console doctrine:migrations:migrate --no-interaction; then
  echo "Symfony migrations completed successfully"
else
  echo "Error: Symfony migrations failed"
  exit 1
fi

if php bin/console doctrine:fixtures:load --no-interaction; then
  echo "Symfony fixtures completed successfully"
else
  echo "Error: Symfony fixtures failed"
  exit 1
fi

php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --no-interaction --env=test
php bin/console doctrine:fixtures:load --no-interaction --env=test


php-fpm

sleep infinity
