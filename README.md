# Product Catalog
News aggregator (RSS) 

## Description

Small web application that implements Aggregator System using Laravel and Vue.js.

## Features

- Ability to schedule update of feeds using CRON job or Task Scheduler
- Filter feeds by category


## Getting started

### Installation

Clone the repository

    git clone git@github.com:Pjuth/News-Aggregator-RSS.git

Switch to the repo folder

    cd News-Aggregator-RSS

Install all the dependencies using composer and npm

    composer install
    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations and seeds (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve
    
Download/update feeds using artisan command
    
    php artisan feeds:update
    
Or using CRON Job.

You can now access the server at http://localhost:8000

## CRON Job

Add an Cron job which executes Laravel scheduler every minute. Go to your terminal, ssh into your server, cd into your project and run this command to open the server Crontab file

    crontab -e
    
Paste the code below into the file, save and then exit

    * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1