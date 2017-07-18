#!/bin/bash

apt-get install -y php-xdebug
echo "zend_extension=/usr/lib/php/20151012/xdebug.so
xdebug.default_enable=1
xdebug.remote_enable=1
xdebug.remote_handler=dbgp
xdebug.remote_host=10.0.2.15
;xdebug.remote_connect_back=1 ; Use remote_host or remote_connect_back. With a local VM remote_connect_back should work also.
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=0
xdebug.remote_log=/tmp/php5-xdebug.log
xdebug.force_display_errors=On
xdebug.idekey=netbeans-xdebug
xdebug.force_error_reporting=1" > /etc/php/7.0/apache2/conf.d/20-xdebug.ini

apt-get install -y php7.0-mbstring
apt-get install -y php7.0-xml

if type composer.phar >/dev/null 2>&1
    then echo "composer added ok"
    exit 0
else
    echo 'composer not found in path, installing...'
    cd /tmp/
    php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
    php -r "if (hash('SHA384', file_get_contents('composer-setup.php')) === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    mv /tmp/composer.phar composer
    mv composer /usr/local/bin/
fi

if type composer >/dev/null 2>&1
  then echo "composer installed ok"
  exit 0
else
    echo "composer not found in path!  ** INSTALL FAILED **"
    echo "see composer.sh"
  exit 1
fi


