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
  apt-get update && apt-get install -y --no-install-recommends --allow-unauthenticated \
  wget \
  zip \
  gzip \
  unzip \
  git \
  cron \
  vim \
  iputils-ping \
  telnet \
  openssl \
  libssl-dev \
  net-tools ; \
  \
  # gd
  apt-get install -y --allow-unauthenticated \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libxpm-dev ; \
  \
  # intl
  apt-get install -y --allow-unauthenticated icu-devtools libicu-dev zlib1g-dev ; \
  \
  # soap xsl xmlrpc wddx readline
  apt-get install -y --allow-unauthenticated libxml2-dev libxslt-dev libreadline-dev libedit-dev ; \
  \
  # bz2 mcrypt zip
  apt-get install -y --allow-unauthenticated libbz2-dev libmcrypt-dev libzip-dev; \
  \
  # readline snmp
  apt-get install -y --allow-unauthenticated libreadline-dev libsnmp-dev snmp ; \
  \
  # ldap
  apt-get install -y --allow-unauthenticated libldb-dev libldap2-dev ; \
  \
  # other
  # graphicsmagick \
  # libgraphicsmagick1-dev \
  # imagemagick \
  # libmagickwand-dev \
  apt-get install -y --allow-unauthenticated \
  libssl-dev \
  libmhash-dev \
  procps \
  libtinfo5 \
  libpq-dev \
  ntpdate ;

####################################################################################
# 安装 PHP 扩展
####################################################################################
# --with-freetype-dir=/usr/include/freetype2/ \

RUN docker-php-ext-configure gd --with-xpm-dir=/usr/include/ --with-jpeg-dir=/usr/include/ ; \
  docker-php-ext-install -j$(nproc) gd ; \
  \
  # readline
  docker-php-ext-configure readline --with-readline CPPFLAGS="-I/usr/include/readline" ; \
  docker-php-ext-install readline ; \
  \
  # 常用扩展
  docker-php-ext-install bcmath mcrypt exif ; \
  \
  # 其他
  docker-php-ext-install mysqli \
  pdo_mysql \
  bz2 \
  calendar \
  exif \
  gettext \
  pcntl \
  readline \
  pgsql \
  pdo_pgsql \
  shmop \
  sockets \
  wddx \
  xsl \
  zip \
  opcache \
  xmlrpc \
  soap \
  mbstring \
  sysvmsg \
  sysvsem \
  sysvshm \
  ldap ; \
  # intl
  docker-php-ext-configure intl --with-icu-dir=DEFAULT ; \
  docker-php-ext-install intl ; \
  # \
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
