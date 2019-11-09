# MyGrades server
[![Apache2 License](https://img.shields.io/badge/license-APACHE2-blue.svg?style=flat-square)](/LICENSE)
[![Travis CI master](https://img.shields.io/travis/MyGrades/mygrades-server/master.svg?style=flat-square)](https://travis-ci.org/MyGrades/mygrades-server/builds)

**Warning: Discontinued since 09/11/2019**

MyGrades server is used as the backend for the Android app [MyGrades](https://github.com/MyGrades/mygrades-app). It is written in PHP using the Laravel framework.

Its two main purposes are:
* define [rules](https://github.com/MyGrades/mygrades-server/tree/master/database/seeds/universities) on how to scrape a students grades for specific universities
* serve these rules via a simple REST api to the clients

It is important to note, that the server does not receive or store any information about the user such as the username or password, nor his or her grades. These will be used solely on the client.

## Installation

Prerequisites: [Docker](https://www.docker.com/) and [Docker Compose](https://docs.docker.com/compose/)

Please add the following entries to your hosts file.
```bash
127.0.0.1 mygrades.dev
127.0.0.1 phpmyadmin.mygrades.dev
```

Alternatively you can adjust the `VIRTUAL_HOST` environment variable in [docker-compose.yml](docker-compose.yml) to your needs.

```bash
git clone https://github.com/MyGrades/mygrades-server.git
cd mygrades-server

# set up DB configuration, only executing the commands and not modifying the files works out of the box ;)
cp docker/db/database.example docker/db/database
cp docker/db/password.example docker/db/password
cp docker/db/root-password.example docker/db/root-password
cp docker/db/user.example docker/db/user
cp .env.example .env # edit to your needs (only DB_* necessary)

# set folder permissions
chown -R <webserver_user>:<webserver_group> /path/to/mygrades-server
find /path/to/mygrades-server -type f -exec chmod 644 {} \;
find /path/to/mygrades-server -type d -exec chmod 755 {} \;
chmod -R ug+rwx /path/to/mygrades-server/storage /path/to/mygrades-server/bootstrap/cache

# run containers and install dependencies
cd docker

# export USER_ID from current <webserver_user> on production
export USER_ID="$(id -u):$(id -g)"

# run mygrades-server
docker-compose -f docker-compose.dev.yml up -d
docker exec php composer install

# migrate and seed database
docker exec php php artisan migrate:install
docker exec php php artisan migrate:refresh --seed

# stop & remove containers
docker-compose down
```

Point your [app](https://github.com/MyGrades/mygrades-app) to the server url `http://mygrades.dev/`.

## Tests
To execute the unit tests simply run
```bash
docker exec php phpunit
```

## Used third-party libraries
* [Laravel](https://github.com/laravel/laravel)
* [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
* [CSV Seeder](https://github.com/Flynsarmy/laravel-csv-seeder)
* [PHP Unit](https://github.com/sebastianbergmann/phpunit)
* [Responsive Email Template](https://github.com/leemunroe/responsive-html-email-template)
* [Composer](https://github.com/composer/composer)

## License

This project is licensed under the [Apache Software License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).

See [`LICENSE`](LICENSE) for more information.

    Copyright 2015 - 2018 Jonas Theis, Tilman Ginzel

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
