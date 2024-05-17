FROM php:7.4-fpm
RUN apt-get update && apt-get install -y nginx

COPY ./config/nginx/default /etc/nginx/sites-available/default
COPY ./config/nginx/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

COPY . /var/www
RUN chown -R www-data:www-data /var/www

# Stel PHP-FPM loginstellingen in om foutmeldingen naar stderr te sturen
RUN echo "log_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-logging.ini
RUN echo "error_log = /proc/self/fd/2" >> /usr/local/etc/php/conf.d/docker-php-ext-logging.ini
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-logging.ini
RUN echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-logging.ini
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-logging.ini

# Pas PHP-FPM pool configuratie aan om foutmeldingen naar stderr te sturen
RUN echo "php_flag[display_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_value[error_log] = /proc/self/fd/2" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

EXPOSE 80
#CMD service nginx start && php-fpm
CMD ["tail", "-f", "/dev/null"]