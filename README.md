# ![Laravel TRAVEL AGENCY](logo.png)

[![Build Status](https://img.shields.io/travis/gothinkster/laravel-realworld-example-app/master.svg)](https://travis-ci.org/gothinkster/laravel-realworld-example-app) [![Gitter](https://img.shields.io/gitter/room/realworld-dev/laravel.svg)](https://gitter.im/realworld-dev/laravel) [![GitHub stars](https://img.shields.io/github/stars/gothinkster/laravel-realworld-example-app.svg)](https://github.com/gothinkster/laravel-realworld-example-app/stargazers) [![GitHub license](https://img.shields.io/github/license/gothinkster/laravel-realworld-example-app.svg)](https://raw.githubusercontent.com/gothinkster/laravel-realworld-example-app/master/LICENSE)

> ### Example Laravel codebase containing real world examples (CRUD, auth, advanced patterns and more) that adheres to the [Travel_Agency](https://github.com/AmjadGhzlangit/Travel_Agency.git) spec and API.

This repo is functionality complete — PRs and issues welcome!

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/AmjadGhzlangit/Travel_Agency.git

Switch to the repo folder

    cd Travel_Agency

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone  https://github.com/AmjadGhzlangit/Travel_Agency.git
    cd Travel_Agency
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate 
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : You can create the first admin by running the following command

    php artisan user:create
    
## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
git clone https://github.com/AmjadGhzlangit/Travel_Agency.git
cd Travel_Agency
cp .env.example.docker .env
docker run -v $(pwd):/app composer install
cd ./docker
docker-compose up -d
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
docker-compose exec php php artisan db:seed
docker-compose exec php php artisan serve --host=0.0.0.0
```

The api can be accessed at [http://localhost:8000/api](http://localhost:8000/api).

## API Specification

This application adheres to the api specifications set by the [Thinkster](https://github.com/gothinkster) team. This helps mix and match any backend with any other frontend without conflicts.

> [Full API Spec](https://github.com/gothinkster/realworld/tree/master/api)

More information regarding the project can be found here https://github.com/gothinkster/realworld

----------

# Code overview

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests/Api` - Contains all the api form requests
- `app/RealWorld/Favorite` - Contains the files implementing the favorite feature
- `app/RealWorld/Filters` - Contains the query filters used for filtering api requests
- `app/RealWorld/Follow` - Contains the files implementing the follow feature
- `app/RealWorld/Paginate` - Contains the pagination class used to paginate the result
- `app/RealWorld/Slug` - Contains the files implementing slugs to articles
- `app/RealWorld/Transformers` - Contains all the data transformers
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature/Api` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api/v1

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Bearer Token      |

Refer the [api specification](#api-specification) for more info.
