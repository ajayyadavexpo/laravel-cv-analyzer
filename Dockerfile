FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=off" > /usr/local/etc/php/conf.d/xdebug.ini

    
# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www


COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh \
    && sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm", "-F"]