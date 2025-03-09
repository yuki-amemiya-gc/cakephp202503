# AlmaLinux 9.5 ベースイメージを使用
FROM almalinux:9.5

# 必要なパッケージのインストール
RUN dnf clean all && \
    dnf makecache && \
    dnf -y update && \
    dnf swap -y curl-minimal curl && \
    dnf -y install httpd php php-cli php-mbstring php-intl php-mysqlnd unzip wget git curl vim procps-ng php-fpm && \
    dnf clean all

# Composer のインストール
WORKDIR /tmp
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# CakePHP のインストール (安全な方法)
WORKDIR /tmp
RUN wget https://github.com/cakephp/app/archive/refs/heads/4.x.zip && \
    unzip 4.x.zip && \
    mv app-4.x/* /var/www/html && \
    rm -rf 4.x.zip app-4.x

# Apache の設定ファイルを追加
RUN cat <<EOF > /etc/httpd/conf.d/cakephp.conf
<VirtualHost *:80>
    DocumentRoot "/var/www/html/webroot"
    <Directory "/var/www/html/webroot">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF

# `ServerName` の設定を追加
RUN echo "ServerName localhost" >> /etc/httpd/conf/httpd.conf

# PHP-FPM ソケットディレクトリの作成
RUN mkdir -p /run/php-fpm && \
    chown -R apache:apache /run/php-fpm

# ポートを開放
EXPOSE 80

# コンテナ起動時に `composer install` を実行し、権限を調整
CMD if [ ! -d "/var/www/html/vendor" ]; then composer install --no-dev --prefer-dist; fi && \
    chown -R apache:apache /var/www/html && chmod -R 755 /var/www/html && \
    /usr/sbin/php-fpm && /usr/sbin/httpd -D FOREGROUND
