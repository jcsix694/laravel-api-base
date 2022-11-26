# Laravel API Base

A Laravel API Base. This Repository is using docker to allow use of Laravel & MySql.

## Prerequistes  
- Docker
- PHP v7.3.33 
- Composer v2.1.3

## Getting started 
1. Install prerequisites  
2. Pull down Repository
3. Run `$ composer install`  
4. Run `npm install`
5. Copy `/.env.example` and rename to `.env`  
6. Update DB details in `.env` to match your local setup 
7. Run `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'` to allow to boot up using `sail`
8. Run `sail up -d` to start the project
9. Run  `sail artisan config:cache` to clear the env cache
10. Run `sail artisan migrate` to run migrations

## Commands 
- `sail up` to run the project with debugging
- `sail up -d` to run the project with no debugging
- `sail down` to stop the project
- `sail ps` to check containers that are running
- `sail artisan config:cache` to clear env cache if errors connecting to the database or using env variables
- `sail artisan migrate:status` to check the migrations to run
- `sail artisan migrate` to run the migrations
- `sail artisan migrate:rollback` to rollback the previous migrations which has been executed

## Services (Name: Port)
- API: 80
- MySQL: 3366
- Redis: 6379

## Endpoints
- POST api/auth
    - <em>Authorizes a loging and returns a Bearer Token for the user</em>
- POST api/users
    - <em>Creates a customer</em>
- GET api/users/me
    - <em>Returns data a user using an active Bearer Token</em>
