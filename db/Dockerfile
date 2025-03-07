# 使用するベースイメージを指定
FROM mysql:8.0

# 環境変数の設定
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=cakephp
ENV MYSQL_USER=user
ENV MYSQL_PASSWORD=password

# カスタムの MySQL 設定ファイルをコピー
COPY ./my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 644 /etc/mysql/conf.d/my.cnf