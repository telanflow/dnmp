FROM elasticsearch:7.1.0

ARG VERSION=7.1.0

RUN \
  chmod 0777 -R data ; \
  chmod 0777 -R logs ; \
  chmod 0777 -R config ; \
  \
  # ⬇ 安装 IK分词器
  elasticsearch-plugin install https://github.com/medcl/elasticsearch-analysis-ik/releases/download/v${VERSION}/elasticsearch-analysis-ik-${VERSION}.zip;
