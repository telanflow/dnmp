FROM php:8.4-fpm-bullseye

COPY resource /home/resource

ARG TIME_ZONE=UTC

ARG MongoDB=mongodb-1.20.1.tgz
ARG OPEN_SWOOLE=openswoole-22.1.2.tgz
ARG SWOOLE=swoole-6.0.0.tgz
ARG REDIS=redis-6.1.0.tgz
ARG MCRYPT=mcrypt-1.0.7.tgz
ARG XDEBUG=xdebug-3.4.1.tgz

ENV TIME_ZONE=${TIME_ZONE} LC_ALL=C.UTF-8

RUN set -eux; \
  # ⬇ 修改时区
  ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime ; \ 
  echo $TIME_ZONE > /etc/timezone ; \
  \
  # ⬇ 安装 PHP Composer
  mv /home/resource/composer.phar /usr/local/bin/composer ; \
  chmod 755 /usr/local/bin/composer ; \
  \
  # ⬇ 更新、安装基础组件
  apt-get update --fix-missing; \
  apt-get upgrade -y --allow-unauthenticated ; \
  # 基础
  apt-get install -y --allow-remove-essential --no-install-recommends --allow-unauthenticated \
  wget \
  zip \
  unzip \
  git \
  cron \
  vim \
  iputils-ping \
  telnet \
  openssl \
  libssl-dev \
  apt-transport-https \
  ca-certificates \ 
  zsh \
  net-tools ; \
  # gd
  apt-get install -y --allow-unauthenticated libfreetype6-dev \
  libjpeg62-turbo-dev \
  libwebp-dev \
  libpng-dev \
  libjpeg-dev \
  libvpx-dev \
  libxpm-dev ; \
  # imagick
  apt-get install -y --allow-unauthenticated libmagickwand-dev libgraphicsmagick1-dev ; \
  # intl
  apt-get install -y --allow-unauthenticated libicu-dev libz-dev ; \
  # bz2 zip
  apt-get install -y --allow-unauthenticated libbz2-dev libzip-dev zlib1g-dev ; \
  # imap
  apt-get install -y --allow-unauthenticated libkrb5-dev ; \
  # ldap
  apt-get install -y --allow-unauthenticated libldb-dev libldap2-dev ; \
  # lz4
  apt-get install -y --allow-unauthenticated liblz4-dev ; \
  # snappy
  apt-get install -y --allow-unauthenticated libsnappy-dev; \
  # readline snmp
  apt-get install -y --allow-unauthenticated libreadline-dev libsnmp-dev snmp ; \
  # mcrypt
  apt-get install -y --allow-unauthenticated libmcrypt-dev ; \
  # mongodb
  apt-get install -y --allow-unauthenticated libicu-dev libsasl2-dev libsnappy-dev zlib1g-dev libsasl2-dev ; \
  # redis
  apt-get install -y --allow-unauthenticated libzstd-dev ; \
  # swoole
  apt-get install -y --allow-unauthenticated libcurl4-gnutls-dev libpq-dev ; \
  # xmlrpc xsl yaml 
  apt-get install -y --allow-unauthenticated libxml2-dev libxslt-dev libyaml-dev ; \
  # other
  apt-get install -y --allow-unauthenticated libtinfo5 \
  procps \
  libmhash-dev \
  librabbitmq-dev \
  uuid-dev \
  libssh2-1-dev \
  libzookeeper-mt-dev \
  libpcre3-dev \
  ntpdate ;

####################################################################################
# 安装 PHP 扩展
####################################################################################

RUN docker-php-ext-configure gd --prefix=/usr --with-freetype --with-jpeg ; \
  docker-php-ext-install -j$(nproc) gd ; \
  # 常用
  docker-php-ext-install pdo_mysql \
  pgsql \
  pdo_pgsql \
  mysqli \
  bz2 \
  zip \
  sockets \
  bcmath \
  mbstring \
  soap \
  gettext \
  calendar \
  pcntl \
  exif \
  shmop \
  xsl \
  readline \
  ldap; \
  # intl
  docker-php-ext-install intl ; \
  # \
  # ⬇ XDebug
  # pecl install /home/resource/$XDEBUG ; \
  \
  # ⬇ Mcrypt
  pecl install /home/resource/$MCRYPT ; \
  echo "extension=mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini ; \
  \
  # ⬇ Imagick
  pecl install imagick && docker-php-ext-enable imagick; \
  \
  # ⬇ Redis
  pecl install /home/resource/$REDIS ; \ 
  echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini ; \
  # \
  # # ⬇ Open Swoole
  # pecl install /home/resource/$OPEN_SWOOLE ; \
  # echo "extension=openswoole.so" > /usr/local/etc/php/conf.d/openswoole.ini ; \
  \
  # ⬇ Swoole
  pecl install /home/resource/$SWOOLE ; \
  echo "extension=swoole.so" > /usr/local/etc/php/conf.d/swoole.ini ; \
  \
  # ⬇ MongoDB
  pecl install /home/resource/$MongoDB ; \
  echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini ; \
  \
  # ⬇ 清理
  rm -rf /var/lib/apt/lists/* ; \
  apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false ; \
  rm -rf /home/resource ;
