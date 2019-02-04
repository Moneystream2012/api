FROM ubuntu:16.04

RUN apt-get clean && apt-get -y update && apt-get install -y locales curl software-properties-common git \
  && locale-gen en_US.UTF-8
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php \
&& apt-get update \
&& apt-get install -y --force-yes \
php-bcmath \
php7.1-bz2 \
php7.1-cli \
php7.1-common \
php7.1-curl \
php7.1-cgi \
php7.1-dev \
php7.1-fpm \
php7.1-gd \
php7.1-json \
php7.1-mbstring \
php7.1-mcrypt \
php7.1-mysql \
php7.1-xml \
php7.1-xmlrpc \
php7.1-xsl \
php7.1-zip  \
php7.1-xdebug  \
php-mongodb \
ant

RUN curl https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php
RUN composer global require "fxp/composer-asset-plugin:^1.3.1"

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html
ADD .docker/php/endpoint.sh /endpoint.sh
RUN chmod 755 /endpoint.sh

#ADD .docker/php/MinexCoin/minexcoind /root/MinexCoin/minexcoind
#ADD .docker/php/MinexCoin/minexcoin-cli /root/MinexCoin/minexcoin-cli

#RUN chmod +x /root/minexcoind
#RUN chmod +x /root/minexcoin-cli

RUN usermod -u 1000 www-data
ENV TERM xterm

ADD .docker/php/logs/cron.log /var/log/cron.log

RUN touch /var/log/cron.log

RUN chmod 0755 /var/log/cron.log

#cli
EXPOSE 17786

EXPOSE 9000
CMD ["/endpoint.sh"]
