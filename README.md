

## Features
1. Login
2. Admin features such as Adding sellers with panel and listing them
3. Sellers can create products for their shop
4. Users can find their nearest products and buy them
5. Unit test
6. Vue components


### Clone the project and run composer

```console
composer install
```


### Run this command to create admin, roles & permissions , customer and seller:

```console
php artisan migrate --seed
```

#### Then try these for login :

```console
-email : admin@test.com
-password : password

-email : customer@test.com
-password : password

-email : seller@test.com
-password : password

```



## This project also contains unit tests for apis

```console
php artisan test
```



