Auth Pkg for Laravel


A simple authentication package for Laravel 11+ with OTP-based password reset.

Features
User Registration, Login & Logout
OTP-based "Forgot Password"
Protected Routes for auth and guest users
Publishable Views & Config

Installation
1. Install via Composer:

composer require ahmadhanzla/authpkg

2. Run Migrations:

php artisan migrate

Publish Assets (Optional)

Publish Views:
php artisan vendor:publish --tag="authpkg-views"

Publish Config:
php artisan vendor:publish --tag="authpkg-config"