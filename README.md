# TMS Callback

## Installation instructions

- Make a copy of `.env.example` and rename it to `.env`
- Update MySQL database information in the `.env` file
- Execute `composer install` to download necessary packages
- Execute `php artisan migrate --seed` to create database tables and insert some sample data
- Execute `php artisan passport:install` to generate API keys 
- Execute `npm install` to install necessary NPM packages
- Execute `npm run dev` to compile JavaScript and Sass assets
- Execute `php artisan serve` to run a local HTTP server for current Laravel instance

## Usage

Open the web address you have set up in your browser.

##### Administration login

| Email | Password |
| --- | --- |
| `test@email.com` | `test123` |
