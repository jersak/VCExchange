# How to

## Installation
Run:
- `composer install`
- `cp .env.example .env`
- `docker-compose up -d`

Check if the three containers are up (app, web, database) using `docker ps`. I'm not sure if this is a windows issue but at first run, the database container tends to stop. If the database container is not running, simply run `docker-compose up -d` again and it should be fine.
After that, run the migrations to create the database and its tables using:
- `php artisan migrate`

At this point the application should be accessible at http://localhost:8080/