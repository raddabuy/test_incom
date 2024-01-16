Базовый проект на Laravel 7 с Docker.
Docker влючает в себя сервисы app (php:7.4-fpm), nginx, mysql 5.7 и adminer.
После команды git clone требуется выполнить следующие действия:
1. docker-compose build
2. docker-compose up -d
3. docker-compose ps  (проверяем, что контейнеры запущены)
4. docker-compose exec app ls -l (проект laravel содержится в сервисе app)
5. docker-compose exec app composer install
6. cp .env.example .env
7. docker-compose exec app php artisan key:generate
8. docker-compose exec app php artisan config:cache
9. localhost:8000 - должна быть стартовая страница Laravel
Если вы видете страницу nginx сервиса, то нужно проверить docker-compose logs nginx.
В случае, если доступ к папке public будет запрещен (Permission denied), дать разрешения вручную:
docker-compose exec nginx chmod 777 /var/www/public

Настройка БД
1. в adminer зайти под пользователем root и создать БД laravel
1. docker-compose exec db bash
2. mysql -u root -p
3. show databases;
4.* GRANT ALL ON laravel.* TO 'root'@'%' IDENTIFIED BY '12345';
5.* FLUSH PRIVILEGES;
6. exit, exit
7. docker-compose exec app php artisan migrate

Если при работе с БД перестает что-то работать, то перезапускает контейнеры либо очищаем кэш
docker-compose exec app php artisan config:cache, docker-compose exec app php artisan config:clear, 
docker-compose exec app php artisan cache:clear

Готово! 
