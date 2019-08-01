FROM php:7.3-fpm

COPY resource /home/resource

ARG CHANGE_SOURCE=true
ARG TIME_ZONE=UTC

ARG SWOOLE=swoole-4.3.4.tgz
ARG REDIS=redis-4.3.0.tgz
ARG MCRYPT=mcrypt-1.0.2.tgz
ARG XDEBUG=xdebug-2.7.2.tgz

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
  rm -rf /etc/apt/sources.list.d/buster.list; \
  if [ ${CHANGE_SOURCE} = true ]; then \
  mv /etc/apt/sources.list /etc/apt/source.list.bak ; \
  mv /home/resource/sources.list /etc/apt/sources.list ; \
  composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ ; \
  fi; \
  \
  # ⬇ 更新、安装基础组件
  apt-get update && apt-get install -y --allow-remove-essential --no-install-recommends \
  procps \
  libtinfo5 \
  libpq-dev \
  libxml++2.6-dev \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  zlib1g-dev \
  libzip-dev \
  libbz2-dev \
  libpng-dev \
  libmcrypt-dev \
  libmhash-dev \
  libssl-dev \
  librabbitmq-dev \
  iputils-ping \
  ntpdate \
  cron \
  vim \
  unzip \
  git \
  wget ;\
\

####################################################################################
# 安装 PHP 扩展
####################################################################################

RUN docker-php-ext-configure gd \
  --with-freetype-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ ; \
  docker-php-ext-install -j$(nproc) gd pdo_mysql ldap mysqli bz2 zip sockets pgsql pcntl pdo_pgsql bcmath soap ; \
  \
  # ⬇ XDebug
  pecl install /home/resource/$XDEBUG ; \
  \
  # ⬇ Redis
  pecl install /home/resource/$REDIS ; \ 
  echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini ; \
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
