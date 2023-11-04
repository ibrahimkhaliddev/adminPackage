## Package Setup
```bash
composer require panelist/admin-package:dev-main
```
After installing the package, the required views, controllers, and other necessary data will be automatically placed in the project directory.

## Migrations
To migrate the package's tables to the database, run the following command:
```bash
php artisan migrate
```

## Setting Up Required Menus
Upload the required menus to the database by executing the following command:
```bash
php artisan db:seed --class=stMenuSeeder
```

## Configuring Admin Permissions
Grant access to the menus to the admin by running the following command:
```bash
php artisan db:seed --class=stUserMenuSeeder
```

## Usage
Once the package is installed, access the admin panel by navigating to `localhost:8000/admin/home`.
