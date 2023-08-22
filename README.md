# single-flat-management

### Installation

1. Clone the project <br>
2. Go to the project root directory <br>
3. In the first place run `composer install` <br>
4. Consequently run `npm install` <br>
5. After that new file create that name is .env
6. You can copy from .env.example all code then paste in .env file
7. Accordingly create a database and its name amarlodge-flats <br>
   If DB_USERNAME and DB_PASSWORD necessary it is good enough. Otherwise root name remove <br>
8. Next run `php artisan migrate:fresh --seed` <br>
9. Eventually `php artisan serve`
