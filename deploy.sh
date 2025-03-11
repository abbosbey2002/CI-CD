#!/bin/bash

echo "Pulling latest changes from Git..."
cd /var/www/html || exit
git pull origin main

echo "Stopping running containers..."
docker-compose down

echo "Building and starting new containers..."
docker-compose up --build -d

echo "Running migrations..."
docker exec dealer-bot php artisan migrate --force

echo "Deployment completed!"



