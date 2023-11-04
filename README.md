# Admin Panel Package

You can install the Package with the following command

## Installation
```bash
composer require panelist/admin-package:dev-main
```
## Package Data

After installation of package all the views, controllers and other required package data will be automatically placed in their places in the project's directory.
```bash
composer require panelist/admin-package:dev-main
```

## Migrations
To upload package's tables to database you need to run the following command.
```bash
php artisan migrate
```

## Required Menus
Upload the Reuqired menus to database by running the following command.
```bash
php artisan db:seed --class=stMenuSeeder
```

## Admin Permissions
To access all the menus to admin you need to run following command to give access to admin.
```bash
php artisan db:seed --class=stUserMenuSeeder
```

## Usage
Once you have installed the package, you can start using the admin panel by navigating to `localhost:8000/admin/home`. By running the url the admin panel will be open.
