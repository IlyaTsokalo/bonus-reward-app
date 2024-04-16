FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update

RUN apt-get -y install git zip libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

RUN pecl install xdebug

COPY docker-entrypoint.sh /home/docker-entrypoint.sh

RUN chmod a+x /home/docker-entrypoint.sh

ENTRYPOINT ["/home/docker-entrypoint.sh"]

CMD ["php-fpm"]
