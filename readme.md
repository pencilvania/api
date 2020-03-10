
## About API

This project is an implementation api with JWT authentication for some CRUD operation with laravel API .  

- [swagger all of services](http://195.248.242.139:8181/api). (swagger only show URL request structure and cannot be use directly)

## Feature

I use dependency Injection and repository pattern in this project .

## Important files

* Entities
    * `App\Affiliations`
    * `App\User` 
    * `App\Superheros`
 * Routes
    * `routes\api.php`
 * Controllers
    * `App\Http\Controllers\*`
 * Repositories
    * `App\Http\Repositories\*`   (All Interface In here)
 * Repository Service Container
    * `App\Providers\RepositoriesServiceProvider`  
 * Custom Response Service
     * `App\Providers\ResponseServiceProvider`    
 * tests
     * `tests\Feauture\*`   
 * tests
      * `tests\Concerns\AttachJwtToken.php`  (this is trait for generate token for test route that need Auth) 

## Installing

- Run "composer install"
- Create a new database (PostgreSQL)
- Clone the .env.example file and rename it to .env
- Config database information  in .env
- Run "php artisan migrate" to generate DB schema
- Run "php artisan db:seed" to seed db (create user **guest@cartrack.pt**  and password **1234** to login panel)
- Run "php artisan jwt:secret"
- Run "php artisan key:generate" to generate application key
- Run "php artisan l5-swagger:generate" to generate API documentations
- Run "php artisan serve" to start the server then go to localhost:8000 and enjoy

## Usage

for call services at first login with email and password at this endpoint
- http://195.248.242.139:8181/api/auth/login [POST method]
if your credential is OK you can see your Token in response and use your token in other services in header for instance :

Authorization Bearer eyJ0eXAiOiJKV1QiLCJhb....

## Unit tests
Run the unit tests with:
```
composer test
```

