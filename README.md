<p style="text-align: center"><a href="https://laravel.com" target="_blank"><img src="https://images.ctfassets.net/j7vj1lxi8fsg/3ZO5sEZDZiSrJvXEY7fJmF/b72e46f40e5f5739df11d24e2ed4acf6/ProductsupLogo.svg?fit=pad&w=147&h=28" width="400" alt="ProductsUp"></a></p>

## Laravel-React app

This app is using ```Laravel framework``` RESTful API, ```Reactjs```, and ```Bootstrap framework v4```. Including ```PHPUnit``` tests!

---
##### Backend RESTful API routes:
- Register
- Login
- Logout
- Table data (serving ```storage/app/table_data.json``` file contents)

---
##### Frontend routes:
- Register page
- Login page
- Home page (including a table which is using ```datatables.net``` package)
---
##### To run the app:
- Create a ```.env``` file
- Run:
    - ```composer install```
    - ```php artisan key:generate```
    - ```touch database/database.sqlite```
    - ```php artisan migrate:fresh --seed```
    - ```php artisan passport:install```

        and finally
    
    - ```php artisan serve```
---

##### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
