FROM php:5.6-fpm

COPY resource /home/resource

ARG CHANGE_SOURCE=true
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
  rm -rf /etc/apt/sources.list.d/buster.list ; \ 
  if [ ${CHANGE_SOURCE} = true ]; then \
  mv /etc/apt/sources.list /etc/apt/source.list.bak ; \
  mv /home/resource/sources.list /etc/apt/sources.list ; \
  composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ ; \
  fi; \
  \
  # ⬇ 更新、安装基础组件
  apt-get update && apt-get install -y --no-install-recommends \
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
  # gd
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  # intl
  libicu-dev \
  # soap xsl xmlrpc wddx
  libxml2-dev \
  libxslt-dev \
  # bz2
  libbz2-dev \
  # mcrypt
  libmcrypt-dev \
  # zip
  libzip-dev \
  # readline
  #libreadline-dev \
  # snmp
  #libsnmp-dev \
  #snmp \
  # ldap
  libldb-dev \
  libldap2-dev \
  # other
  # graphicsmagick \
  # libgraphicsmagick1-dev \
  # imagemagick \
  # libmagickwand-dev \
  libssl-dev \
  libmhash-dev \
  procps \
  libtinfo5 \
  libpq-dev \
  ntpdate ;

####################################################################################
# 安装 PHP 扩展
####################################################################################

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ ; \
  docker-php-ext-install gd intl soap xsl xmlrpc wddx \
  bz2 zip pcntl pdo_mysql mysqli mbstring exif \
  bcmath calendar sockets gettext shmop \
  sysvmsg sysvsem sysvshm mcrypt ldap ; \
  #\
  # ⬇ XDebug
  # pecl install /home/resource/$XDEBUG ; \
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
