FROM php:5.6-fpm

COPY resource /home/resource

ARG CHANGE_SOURCE=false
ARG TIME_ZONE=UTC

ARG SWOOLE=swoole-1.10.5.tgz
ARG REDIS=redis-4.3.0.tgz

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
  rm -rf /etc/apt/sources.list.d/buster.list \ 
  if [ ${CHANGE_SOURCE} = true ]; then \
  mv /etc/apt/sources.list /etc/apt/source.list.bak ; \
  mv /home/resource/sources.list /etc/apt/sources.list ; \
  composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ ; \
  fi \
  \
  # ⬇ 更新、安装基础组件
  apt-get update && apt-get install -y --no-install-recommends \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libjpeg-dev \
  libpng-dev \
  zlib1g-dev \
  graphicsmagick \
  libgraphicsmagick1-dev \
  imagemagick \
  libmagickwand-dev \
  libssh2-1-dev \
  libzip-dev \
  libzookeeper-mt-dev \
  libldb-dev \
  libldap2-dev \
  libssl-dev \
  libmosquitto-dev \
  librabbitmq-dev \
  libicu-dev \
  libxml2-dev \
  libxslt-dev \
  libbz2-dev \
  cron \
  vim \
  unzip \
  git \
  wget \
  libmcrypt-dev \
  libmhash-dev ;

####################################################################################
# 安装 PHP 扩展
####################################################################################

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ ; \
  docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ ; \
  docker-php-ext-install -j$(nproc) gd mcrypt ldap soap xsl xmlrpc bz2 zip pcntl pdo_mysql mysqli exif bcmath calendar sockets ; \
  \
  # ⬇ XDebug
  pecl install xdebug ; \
  \
  # ⬇ Redis
  pecl install /home/resource/$REDIS ; \ 
  echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini ; \
  \
  # ⬇ Swoole
  pecl install /home/resource/$SWOOLE ; \
  echo "extension=swoole.so" > /usr/local/etc/php/conf.d/swoole.ini ; \
  \
  # ⬇ 清理
  rm -rf /var/lib/apt/lists/* ; \
  apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false ; \
  rm -rf /home/resource ;
