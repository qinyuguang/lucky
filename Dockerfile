FROM php:latest

VOLUME ["./:/www/lucky", "/home/logs/project/lucky"]

COPY ./src/conf/crontab /etc/cron.d/lucky

RUN pecl install yaf \
    && pecl clear-cache \
    && chmod 0644 /etc/cron.d/lucky

