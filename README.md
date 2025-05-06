# Story Share
Inspired by AO3, this is a platform designed to for users to read, write and generally share works of fiction. A full stack application built using MySQL, Laravel as an API and Vue 3 as a frontend.

## Getting Started
Story Share consists of a Laravel API backend, Vue frontend and MySQL database. To start the application, you will need to use [Docker Compose](https://docs.docker.com/compose/). 

```bash
docker compose up
```

This will bring the following containers up.

| Name              | Ports             | Description                                       |
|-------------------|-------------------|---------------------------------------------------|
| mysql             | 33061:3306        | Main MySql container                              |
| testing           | 33062:3306        | Testing MySql container                           |
| mail              | 8025:80           | Mail interception container                       |
| api               | 8000:80           | Nginx container                                   |
| fpm               |                   | FPM container                                     |
| vue               | 8080:80           | Vue container                                     |

Once the containers are up, you will need to create the `.env` file for the API.

You can copy the `api/.env.example` file. Make sure if you're using your local IP address for development (instead of localhost) that you update the relevant URLs.

### Install Composer Dependencies
```bash
docker compose exec fpm composer install
```

### Install NPM Dependencies
```bash
docker compose exec vue npm install
```

### Bash
You can bash into the FPM/Vue containers using Docker Compose.

```bash
docker compose exec fpm bash
docker compose exec vue bash
```

### Generate Code Coverage Reports
To generate code coverage reports run this command in the fpm container
```bash
vendor/bin/phpunit --coverage-html=build/coverage
```
or this outside the container
```bash
docker compose exec fpm vendor/bin/phpunit --coverage-html=build/coverage
```

## For Production Build
Running the start script should handle building the containers for production.

```bash
./start.sh
```


## Build 0.3.2
- Vue 3
- Laravel API
- Nginx server
- MySql Database
- Containerized for local development environment
- For production environment, run start.sh
