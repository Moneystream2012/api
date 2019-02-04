<?php
while(true) {
    sleep(5);
    exec('php /var/www/html/bin/yii cron/payouts &', $out);
}