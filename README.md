sudo -i
docker compose build
docker compose run laravel composer install
docker compose run laravel php artisan migrate
docker compose run laravel php artisan db:seed
docker compose up -d
以下でアクセス
https://127.0.0.1