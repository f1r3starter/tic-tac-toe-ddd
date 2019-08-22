FROM php:7.3.0-fpm

RUN apt-get update && apt-get install -y && apt-get install -y --no-install-recommends git zip zlib1g-dev libzip-dev &&  docker-php-ext-install zip

RUN if [ "$APP_ENV" = "dev" ]; then \
        pecl install xdebug && docker-php-ext-enable xdebug; \
    fi

COPY ./devops/Docker/php/xdebug.ini /usr/local/etc/php/conf.d/

RUN usermod -u 1000 www-data

RUN apt-get install git -y

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

COPY composer.json ./

COPY composer.lock ./

RUN composer install --no-scripts --no-autoloader

COPY . ./

RUN composer dump-autoload --optimize

CMD ["php-fpm"]
