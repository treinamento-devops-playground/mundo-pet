FROM phpdockerio/php:8.3-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    git \
    php8.3-memcached \
    php8.3-sqlite3 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie os arquivos do projeto para o diretório de trabalho
COPY . /application

# Instale as dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Ajuste as permissões para o PHP-FPM
RUN chown -R www-data:www-data /application && \
    chmod -R 755 /application

