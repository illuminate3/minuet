FROM carstensapporo/apache-base:latest

WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html/

RUN php bin/composer.phar install

EXPOSE 80
ENTRYPOINT ["apache2-foreground"]
