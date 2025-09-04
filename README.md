# Story Share
Inspired by AO3, this is a platform designed to for users to read, write and generally share works of fiction. Eventually, I would like to incorporate elements from from platforms like Patreon or SubscribeStar and have a way for author's to make a some kind of feasible income from this platform.

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

## For Deployment Build
Running the start script should handle building the containers for deployment.

```bash
./start.sh
```

## Upcoming Features
- Collections - Being able to collect stories into named collections. This would be useful for series of stories (e.g. Harry Potter, Game of Thrones, Percy Jackson, etc)
- Content Tags - Tagging stories based on content and performing searches based on those tags. These would be separate from Genres (e.g. A story is an Adventure/Fantasy with Graphic Violence).
-  Metrics - Authors tracking audience interactions with a story (daily/weekly/monthly views) and see what stories engage audiences the most (most liked, most commented, highest word count, highest chapter count, etc)
- Subscriptions - Readers subscribing to a story or author and receiving alerts on a new release (chapter or story). Considering subscribing to collections as well.
- Notifications - Implement live notifications for when a story is updated.

## Eventual Features
- Paid subscriptions with Stripe API integration
- Story Comissions
- Story Prompts/Challenges
- Reporting inappropriate stories (not tagged correctly, breaks TOS, etc)
- Moderator Dashboard (Moderators will have limited access to admin features)
- Site News Blog (maybe Author News Blog too)

## Current Build Stack 0.3.5
- Vue 3
- Laravel API
- Nginx server
- MySql Database
- Containerized for local development environment
- For production environment, run start.sh
