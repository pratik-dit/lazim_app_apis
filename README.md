
## Setup and run application

1. run `composer install` command
2. create `.env` file from `.env.example` file
3. add database configuration into `.env` file
4. run `php artisan key:generate` command
5. run `php artisan migrate` command
6. run `php artisan db:seed` command
7. run `php artisan serve` command

## Note
- Two role added `admin` and `user`
- Admin role user can't be create via register route
- User role can be created via register route

## Admin role user credential
- email: `admin@gmail.com`
- password: `admin1234`

## Postmane Collection
-  Added API postman collection file into root folder
-  File name: lazim_application_postman_collection.json


## All Task Apis are authenticated
- You need to login first and it will generate token
- You need to pass that token into header like:
       - Content-Type: application/json
       - Authorization: Bearer {{token}}
