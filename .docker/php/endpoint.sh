#!/bin/bash

composer install

/var/www/html/bin/yii migrate/up --interactive=0
/var/www/html/bin/yii gii/model --tableName=* --interactive=0 --overwrite=1

chmod +x /root/MinexCoin/*

/root/MinexCoin/minexcoind -conf="/root/Minexcoin.conf" -printtoconsole &

cron

php-fpm7.1