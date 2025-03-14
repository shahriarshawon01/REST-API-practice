1.Install Passport
composer require laravel/passport

If time out error comes then run the bellow command
COMPOSER_MEMORY_LIMIT=-1 composer require laravel/passport

2. Migration
php artisan migrate

3.Key Generate
php artisan passport:install

4.User Model
use Laravel\Passport\HasApiTokens;
use HasApiTokens, HasFactory, Notifiable;

5. Update App\Providers\AuthServiceProvider
use Laravel\Passport\Passport;

In boot function add  
Passport::routes();

6. Update config/auth.php
     follow video
7. create route and function in controller
