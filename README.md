# systeme-test
Test app

# Installation (dev environment)

1. git clone https://github.com/ScorpioT1000/systeme-test.git
2. Install nginx + php 8.1 + php8.1-fpm + postgresql + node + npm 
3. Run ```composer install``` and ```npm install```
4. Run ```php bin/console doctrine:schema:update --force```
5. Run ```npm run dev```
6. Copy .env.dist as .env and configure the params
7. Run ```php bin/console app:initialize-demo``` to create demo data. You can also use ```php bin/console app:drop-data``` to clean db

# Installation (production environment)

1. git clone https://github.com/ScorpioT1000/systeme-test.git
2. Install nginx + php 8.1 + php8.1-fpm + postgresql + node + npm 
3. Run ```composer install``` and ```npm install```
4. Run ```php bin/console doctrine:schema:update --force```
5. Run ```npm run build```
6. Copy .env.dist as .env and configure the params

# About

Grigory © ScorpioT1000@yandex.ru