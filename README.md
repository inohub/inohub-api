<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

docker-compose exec php bash

# TESTS
```
./vendor/bin/phpunit --filter ProfileTest::testUpdate
```

# Очистить кеш
```
php artisan cache:clear
php artisan route:clear
php artisan config:clear 
php artisan view:clear 
```

# Создаем модель + миграцию
```
php artisan make:model Models/BlogCategory -m
```

# Создаем сиды
```
php artisan make:seeder UsersTableSeeder
php artisan make:seeder BlogCategoriesTableSeeder

php artisan generate:model-factor // генерация фабрик для всех моделей
php artisan generate:model-factory User // генерация фабрики на основе модели User
php artisan generate:model-factory --dir app/Models -- User Team
doc https://github.com/mpociot/laravel-test-factory-helper
```

# Запуск сидов
```
php artisan db:seed
php artisan db:seed --class=UsersTableSeeder
php artisan migrate:fresh --seed
```

# Создаем Rest-контроллер
```
php artisan make:controller RestTestController --resource
```

# Список роутов
```
php artisan route:list
```

# Cоздать свой обьект Request
```
php artisan make:request TestRequest
```

# Cоздать Observers
```
php artisan make:observer BlogPostObserver --model=Models/Blog/BlogPost
php artisan make:observer BlogCategoryObserver --model=Models/Blog/BlogCategory
```

Запуск vue
```
npm run watch -- --watch-poll
```

# Horizon panel
```
http://localhost:8000/horizon
```

# Telescope panel
```
http://localhost:8000/telescope
```

# Email Preview
```
https://github.com/themsaid/laravel-mail-preview
```

# DB
```
https://github.com/jarektkaczyk/eloquence
```

# run test
```
./vendor/bin/phpunit --filter ProfileTest::testA
```

# ES

```
php artisan es:reindex_resource --progress --delete

php artisan es:index_resource --delete

php artisan es:reindex_user --progress --delete

php artisan es:index_user --delete

php artisan resource:generate 100
```

# REDIS CLEAN

```
docker-compose exec redis redis-cli

flushdb
```

# DUMP

```
php artisan dump-server --format=html > dump.html

\DB::enableQueryLog();
\DB::getQueryLog()
```

```
cd /spa && npm i && npm run build && cd /application
```