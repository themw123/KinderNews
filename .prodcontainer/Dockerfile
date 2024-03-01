FROM php:8.1-apache
# Install mysqli, upgrade, install git and crone
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y && apt-get install -y git && apt-get -y install cron

# Install Composer
WORKDIR /var/www/html
COPY www .
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install	

#folgendes um die realen remote ips im apache log zu sehen mittels: docker logs --follow php-apache
#achtung workarround. Bei updates kann es sein das es nicht mehr geht da apache.conf nicht verändert werden sollte.
COPY apache/apache2.conf ./
RUN mv apache2.conf /etc/apache2/apache2.conf
#folgendes um die reale ip im php script mittels $_SERVER['REMOTE_ADDR'] zu sehen. Zusätzlich noch zwei Zeilen im apache.conf script am ende einfügen:
#RemoteIPHeader X-Forwarded-For
#RemoteIPInternalProxy 172.0.0.0/8
RUN a2enmod remoteip

COPY cronjobs /etc/cron.d/cronjobs
RUN chmod 0644 /etc/cron.d/cronjobs
CMD cron && docker-php-entrypoint apache2-foreground


