#!/bin/bash

#docker-php-ext-install iconv zip xml xmlreader simplexml gd
#composer require phpoffice/phpspreadsheet

if [ ! -d $(pwd)/vendor ]; then
    docker-php-ext-install pdo_mysql iconv zip xml xmlreader simplexml gd
    apt-get update &&  \
    apt-get install -y libzip-dev libssl-dev git unzip libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6-dev && \
    docker-php-ext-configure gd --with-gd --with-webp-dir --with-jpeg-dir \
    --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir \
    --enable-gd-native-ttf && \
    docker-php-ext-install gd && \
    curl -s https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
fi
if [ "$INSTALL_VENDOR" = "y" ]; then
    sed 's/DB_HOST=127.0.0.1/DB_HOST=db/;s/DB_PASSWORD=/DB_PASSWORD=root/' .env.example > .env && \
    chmod 777 .env && \
    chmod 777 -R storage && \
    composer install && \
    chmod 775 -R /opt/vendor
    if [ "$(cat .env | grep -w 'APP_KEY=' | cut -d = -f 1)" = APP_KEY ]; then
        composer update && \
        php artisan key:generate && \
        useradd "$USER" -d /home/"$USER" -m
    fi
fi
docker-php-entrypoint php-fpm && su "$USER"


#docker exec php1 useradd dennys -d /home/dennys
#docker exec -it php1 /bin/bash
#su dennys





# remove all
# docker container prune -f && docker rmi $(docker images -q) -f && sudo rm -rf vendor/ .env
