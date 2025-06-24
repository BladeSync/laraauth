Laraauth by BladeSync
A simple, complete, and publishable authentication package for Laravel 11+ with OTP-based password reset.

Features
User Registration, Login & Logout.

Secure, OTP-based "Forgot Password" functionality.

Protected routes for both authenticated and guest users.

Fully Publishable: You have full control over the code.

Publish and customize all views.

Publish and customize the config file.

Publish a default home page to get started quickly.

Install routes directly into your web.php for full customization.

Installation
Install via Composer:

composer require bladesync/laraauth

Run Migrations: This will create the users and password_reset_otps tables.

php artisan migrate

(Optional) Install Routes: If you want to customize the routes, run this command. It will copy all routes from the package to your application's routes/web.php file.

Warning: This will overwrite your existing routes/web.php file.

php artisan laraauth:install-routes

Publishing Assets (Optional)
You can publish different parts of the package to customize them.

Publish Config File
This will create config/laraauth.php.

php artisan vendor:publish --tag="laraauth-config"

Publish All Views
This will create the resources/views/laraauth directory with all authentication views.

php artisan vendor:publish --tag="laraauth-views"

Publish Only the Home Page
This is a quick way to get a starter dashboard page at resources/views/home.blade.php.

php artisan vendor:publish --tag="laraauth-home"
