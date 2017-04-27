XML Orders
========================

Introduction
--------------

This application loads two xmls and persist their informations.
It uses Symfony2, doctrine, composer, mysql.

Installation
-------------

1. Clone the project
2. Run the command `composer install`
3. Setup Database Configuration at `app/config/parameters.yml`
4. Run the command `php app/console doctrine:schema:create` to create tables
4. Run the command `php app/console server:run` to open server

Tests
------

1. You have to manually run fixtures with command `php app/console doctrine:fixtures:load --no-interaction` to seed your database
2. Run the command `phpunit -c app`

Feats
-------

1. Drag & Drop component
2. Functional Tests
3. Generated API Simple Document (you have to put `?_doc=1` after the API urls)
4. Repository Pattern and Depency Injection (Controllers and Repositories are services)
