
**Setup the env file**
* cd src/
* cp env.example .env

**Project Setup**

1. composer install
2. php artisan migrate
3. php artisan passport:install
4. php artisan db:seed
5. php artisan storage:link


**Api Documentation Setup**

1. php artisan docs:generate
2. http://127.0.0.1:8000/docs/

