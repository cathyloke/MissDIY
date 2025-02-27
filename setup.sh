#!/bin/bash

echo "Starting Laravel Setup..."

# Install dependencies
composer install

# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate

echo "Laravel setup completed!"
