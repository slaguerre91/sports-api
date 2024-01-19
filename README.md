# Sports API

This web app allows users to fetch game data from [API-NBA](https://api-sports.io/documentation/nba/v2).

## Tech Stack

-   PHP
-   Laravel
-   HTML
-   CSS
-   Bootstrap
-   Font Awesome

## Installation

### Install dependencies

```bash
composer install
```

### Configure .env file

Add the below variables:

```.ENV
SPORTS_API_HOST="hostname.com"
SPORTS_API_KEY="apikey"
```

### Running the app

Run the below command

```bash
php artisan serve
```

### Deployed

Alternatively, web app is deployed on Heroku at the following link http://phplaravel-973382-3671050.cloudwaysapps.com

## How to navigate folder structure

This project was built using the Laravel framework. As a result, many of the directories and files are not part of the custom code. Below is a description of each folder or file relevent to this project.

### Routes

routes/web.php

### Controllers

app/Http/Controllers

### Views

resources/views

### Public resources

public
