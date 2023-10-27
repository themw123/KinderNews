FROM mcr.microsoft.com/devcontainers/php:1-8.2-bullseye

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*



WORKDIR /var/www/html
COPY ./ .


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer update && composer install


#CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]

