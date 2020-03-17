FROM php:7.4-fpm

RUN set -e \
    apt-get update \
    apt-get upgrade -y \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install bcmath pdo_mysql

CMD ["php-fpm"]
