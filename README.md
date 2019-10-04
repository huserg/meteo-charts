# MeteoCharts

This project is a Laravel webapp that provide a secured interface to monitor a RPi Meteo project.


## Getting started

### Clone the repository

```
git clone git@github.com:R-Men/MeteoCharts.git
```

### Configuration

#### Environment configuration

Configure an apache vhost.

#### App configuration

Copy the `.env.exemple` and rename it to `.env`

##### Database

First you need to create a MySQL database.

In the `.env` file set the database connection informations

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

### Dependencies

Install php dependencies
```
composer install
```

Install front-end dependencies
```
npm install
```

### Installation

Run the following commends to install the webapp

Generate the unique key :
```
php artisan key:generate
```

Compile assets :
```
npm run prod
```
