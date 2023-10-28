FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo pdo_mysql

# install xdebug
#RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

#zwar vorher schon als volume in docker-compose, aber das wird ja erst nach image gemacht, er kennt es also noch nicht
#ist für ausführung des compose befehls wichtig.
WORKDIR /var/www/html
COPY ./ .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer update && composer install


CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]

