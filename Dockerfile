FROM phpdockerio/php:8.3-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    git \
    php8.3-memcached \
    php8.3-sqlite3 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /application

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /application && \
    chmod -R 755 /application

