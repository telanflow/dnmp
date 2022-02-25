FROM php:7.4-fpm-buster

COPY resource /home/resource

ARG CHANGE_SOURCE=true
ARG TIME_ZONE=UTC

ARG MongoDB=mongodb-1.12.1.tgz
ARG OPEN_SWOOLE=openswoole-4.10.0.tgz
ARG SWOOLE=swoole-4.8.7.tgz
ARG REDIS=redis-5.3.7.tgz
ARG MCRYPT=mcrypt-1.0.4.tgz
ARG XDEBUG=xdebug-3.1.3.tgz

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
  # ⬇ 替换源
  rm -rf /etc/apt/sources.list.d/buster.list ; \
  if [ ${CHANGE_SOURCE} = true ]; then \
    mv /etc/apt/sources.list /etc/apt/source.list.bak; \ 
    mv /home/resource/sources.list /etc/apt/sources.list; \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ ; \
  fi; \
  \
  # ⬇ 更新、安装基础组件
  apt-get update; \
  apt-get upgrade -y; \
  apt-get install -y --allow-remove-essential --no-install-recommends \
  # tools
  wget \
  zip \
  unzip \
  git \
  cron \
  vim \
  iputils-ping \
  telnet \
  net-tools \
  \
  libmagickwand-dev \
  libz-dev \
  # intl
  libicu-dev \
  # bz2
  libbz2-dev \
  # zip
  libzip-dev \
  # ldap
  libldb-dev \
  libldap2-dev \
  # mcrypt
  libmcrypt-dev \
  # other
  libtinfo5 \
  libpq-dev \
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  libssl-dev \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  zlib1g-dev \
  libpng-dev \
  procps \
  libmhash-dev \
  librabbitmq-dev \
  ntpdate ;

####################################################################################
# 安装 PHP 扩展
####################################################################################

RUN docker-php-ext-configure gd \
  --with-freetype-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ ; \
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
