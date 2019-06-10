FROM elasticsearch:7.1.0

ARG CHANGE_SOURCE=false

RUN \
  # ⬇ 更新、安装基础组件
  yum install -y vim wget git ; \
  \
  # ⬇ 替换源
  if [ ${CHANGE_SOURCE} = true ]; then \
  mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.bak ; \
  wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo; \
  wget -O /etc/yum.repos.d/epel.repo http://mirrors.aliyun.com/repo/epel-7.repo; \
  fi \

  RUN \
  # ⬇ 设置0777权限
  chmod 0777 -R data ; \
  chmod 0777 -R logs ; \
  chmod 0777 -R config ; \
  \
  # ⬇ 安装 IK分词器
  elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v7.1.0/elasticsearch-analysis-ik-7.1.0.zip;
