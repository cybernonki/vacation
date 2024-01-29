sudo -i

ソースのディレクトリ移動

docker compose build

docker compose run laravel composer install

docker compose run laravel php artisan migrate

docker compose run laravel php artisan db:seed

docker compose run laravel npm install

docker compose run laravel npm run build

docker compose up -d


sudo chmod -R 777 /vacation

git checkout .

※not root user


以下でアクセス

https://127.0.0.1


中に入る

docker compose exec laravel bash
