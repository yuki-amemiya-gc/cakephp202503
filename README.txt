■起動
docker-compose up -d --build
docker-compose up -d
docker run --rm -it almalinux:9.5 /bin/bash

■削除
docker-compose down

■起動確認
docker ps -a

■アクセス
docker exec -it cakephp202503-web-1 bash
docker exec -it cakephp202503-db-1 bash
docker exec -it cakephp202503-db-1 mysql -u user -p
ls -al /etc/mysql/conf.d/my.cnf

■ログ
docker logs db 
telnet localhost 3306
■確認
http://localhost:8080/hello