FROM nginx:latest

COPY resource /home/resource

ARG CHANGE_SOURCE=true
ARG TIME_ZONE=UTC

ENV TIME_ZONE=${TIME_ZONE} LC_ALL=C.UTF-8

RUN \
  # ⬇ 修改时区
  ln -snf /usr/share/zoneinfo/$TIME_ZONE /etc/localtime ; \ 
  echo $TIME_ZONE > /etc/timezone ; \
  \
  # ⬇ 替换源
  rm -rf /etc/apt/sources.list.d/buster.list ; \ 
  if [ ${CHANGE_SOURCE} = true ]; then \
  mv /etc/apt/sources.list /etc/apt/source.list.bak ; \
  mv /home/resource/sources.list /etc/apt/sources.list ; \
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
  ntpdate ;
