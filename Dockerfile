FROM php:latest

VOLUME ["/home/logs/project/lucky", "/home/logs/php", "/var/mail"]

COPY ./ /www/lucky/
COPY ./src/conf/crontab /etc/cron.d/lucky
COPY ./conf/online/php.ini /usr/local/etc/php/php.ini
COPY ./conf/online/fpm.conf /usr/local/etc/php-fpm.d/lucky.conf

RUN pecl install yaf \
    && pecl clear-cache \
    && chmod 0644 /etc/cron.d/lucky \
    && apt-get update \
    && apt-get install -y cron \
    && crontab /etc/cron.d/lucky \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/*

CMD ["cron", "-f"]

