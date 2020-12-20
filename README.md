# stoneacre
PHP Technical Test on Laravel

dennys@linux:~/Projects/stoneacre$ docker-compose up --build
Creating network "stoneacre_develop" with driver "bridge"
Creating volume "stoneacre_stoneacre" with default driver
Creating db
Creating php7
Creating nginx
Attaching to db, php7, nginx

Routes:

- Import car
http://localhost/api/import-car

- Car Index
http://localhost/api/car

- Car Details
http://localhost/api/car/<id>
