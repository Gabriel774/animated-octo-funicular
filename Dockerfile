FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    cron \
    supervisor \
    default-mysql-client \
    libmariadb-dev \
    zip unzip curl git \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY src ./ 

COPY container-config/crontab /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron
RUN touch /var/log/cron.log

COPY container-config/supervisord.conf /etc/supervisord.conf

COPY container-config/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
