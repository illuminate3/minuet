FROM carstensapporo/apache-base:latest

ARG DATABASE_URL

WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html/

RUN php bin/composer.phar install \
    && yarn install --ignore-engines --force \
    && yarn build \
    && chown www-data.www-data /var/www/html/* -R \
    && bin/console d:m:m -n --allow-no-migration

EXPOSE 80
ENTRYPOINT ["apache2-foreground"]
