FROM webdevops/php-nginx:ubuntu-16.04
RUN apt-get update \
    && apt-get install php7.0-pgsql -y \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require "fxp/composer-asset-plugin:^1.3.0" \
    && composer config -g github-oauth.github.com 8cc0514beb7d0b8af9dc7835fd38487d110c08fd \
    && sed -ie 's/sendfile on/sendfile off/g' /etc/nginx/nginx.conf
