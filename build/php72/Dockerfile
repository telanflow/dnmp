FROM php:7.2-fpm-buster

COPY resource /home/resource

ARG CHANGE_SOURCE=true
ARG TIME_ZONE=UTC

ARG MongoDB=mongodb-1.15.3.tgz
ARG OPEN_SWOOLE=openswoole-4.10.0.tgz
ARG SWOOLE=swoole-4.8.13.tgz
ARG REDIS=redis-5.3.7.tgz
ARG MCRYPT=mcrypt-1.0.6.tgz
ARG XDEBUG=xdebug-3.1.3.tgz

ENV TIME_ZONE=${TIME_ZONE} LC_ALL=C.UTF-8

RUN \
  # ⬇ 修改时区
  ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime ; \ 
  echo $TIME_ZONE > /etc/timezone ; \
  \
  # ⬇ 安装 PHP Composer
  mv /home/resource/composer.phar /usr/local/bin/composer ; \
  chmod 755 /usr/local/bin/composer ; \
  \
  # ⬇ 替换源
  rm -rf /etc/apt/sources.list.d/buster.list ; \
  if [ ${CHANGE_SOURCE} = true ]; then \
    mv /etc/apt/sources.list /etc/apt/source.list.bak; \ 
    mv /home/resource/sources.list /etc/apt/sources.list; \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ ; \
  fi; \
  \
  # ⬇ 更新、安装基础组件
  apt-get update -y --allow-unauthenticated; \
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

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ ; \
  docker-php-ext-install -j$(nproc) gd intl pdo_mysql ldap mysqli bz2 zip sockets pgsql pdo_pgsql bcmath soap pcntl; \
  # \
  # ⬇ XDebug
  # pecl install /home/resource/$XDEBUG ; \
  \
  # ⬇ Imagick
  pecl install imagick && docker-php-ext-enable imagick; \
  \
  # ⬇ MongoDB
  pecl install /home/resource/$MongoDB ; \
  echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini ; \
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
  # ⬇ Mcrypt
  pecl install /home/resource/$MCRYPT ; \
  echo "extension=mcrypt.so" > /usr/local/etc/php/conf.d/mcrypt.ini ; \
  \
  # ⬇ 清理
  rm -rf /var/lib/apt/lists/* ; \
  apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false ; \
  rm -rf /home/resource ;
