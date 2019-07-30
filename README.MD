# Project Title

Backend for Perspective Challenge

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

All these instructios are for Ubuntu

Make sure you have  Php 7.2 and above installed.
Make sure you have MySql installed.
Make sure you have Laravel 5.8's Php dependencies such as mbstring installed .




### Installing

Post Cloning

```
cd backend
```

Set up .env file with correct details

```
cp env.example .env
```

Install dependencies

```
composer install
```

Run migration

```
php artisan migrate
```

Run Seeder

```
php artisan db:seed
```


Start server on port 8000

```
php artisan serve
```



## Routes

Routes are prefixed with `api/v1`

Available Routes can be found by running
```
php artisan route:list
```




## Built With

* [Laravel](https://laravel.com/docs/5.8) - Web Framework

