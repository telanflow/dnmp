FROM nginx:latest

COPY resource /home/resource

ARG TIME_ZONE=UTC

ENV TIME_ZONE=${TIME_ZONE} LC_ALL=C.UTF-8

RUN \
  # ⬇ 修改时区
  ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime ; \ 
  echo $TIME_ZONE > /etc/timezone ; \
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
  ntpdate ;
