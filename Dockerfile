FROM carstensapporo/apache-base:latest

#ARG DATABASE_URL

WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html/

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* /var/www/html/var/cache /var/www/html/var/log; \
    php bin/composer.phar install; \
    yarn install --ignore-engines --force; \
    yarn build; \
    chown www-data.www-data /var/www/html/* -R; \
    php bin/console doctrine:database:drop; \
    php bin/console doctrine:database:create; \
    php bin/console doctrine:schema:create; \
    php bin/console doctrine:fixtures:load;

EXPOSE 80
ENTRYPOINT ["apache2-foreground"]
