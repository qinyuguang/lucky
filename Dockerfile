FROM php:latest

VOLUME ["/home/logs/project/lucky", "/home/logs/php/lucky", "/var/mail"]

COPY ./ /www/lucky/
COPY ./src/conf/crontab /etc/cron.d/lucky
COPY ./conf/online/php.ini /usr/local/etc/php/php.ini
COPY ./conf/online/fpm.conf /usr/local/etc/php-fpm.d/lucky.conf

WORKDIR /www/lucky

RUN docker-php-ext-install pdo_mysql \
    && pecl install yaf \
    && pecl clear-cache \
    && chmod 0644 /etc/cron.d/lucky \
    && apt-get update \
    && apt-get install -y cron \
    && crontab /etc/cron.d/lucky \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* \
    && sed -i '/session    required     pam_loginuid.so/c\#session    required     pam_loginuid.so' /etc/pam.d/cron

CMD ["cron", "-f"]

