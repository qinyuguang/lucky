FROM php:latest

VOLUME ["/home/logs/project/lucky"]

COPY ./src/conf/crontab /etc/cron.d/lucky
COPY ./* /www/lucky/

RUN pecl install yaf \
    && pecl clear-cache \
    && chmod 0644 /etc/cron.d/lucky \
    && apt-get update \
    && apt-get install cron \
    && service cron start \
    && crontab /etc/cron.d/lucky \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/*

