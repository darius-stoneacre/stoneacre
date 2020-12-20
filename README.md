# stoneacre
PHP Technical Test on Laravel

run on docker (Linux):
    
    docker-compose up --build
    
or 

    composer update
    php artisan serve
    
don't forget set database config .env

Routes:
- Import car
http://localhost/api/import-csv

- Car Index
http://localhost/api/vehicle

- Car Details
http://localhost/api/vehicle/<id>

- Export CSV
http://localhost/api/export-csv
