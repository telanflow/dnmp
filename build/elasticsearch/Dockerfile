FROM elasticsearch:7.1.0

RUN \
  # ⬇ 更新、安装基础组件
  yum update -y && yum install -y vim \
  curl \
  wget \
  git ;

# ⬇ 安装 IK分词器
# RUN elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v7.1.0/elasticsearch-analysis-ik-7.1.0.zip ;