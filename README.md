# Blaze

Blaze is yet another swipe app, inspired by Tinder. This repository includes RESTful API and reverb WebSocket server.

### Table of Contents

-   [Prerequisites](#prerequisites)
-   [Tech Stack](#tech-stack)
-   [Getting Started](#getting-started)
-   [Migrations](#migration)
-   [Seeding](#seeding)
-   [Development](#development)
-   [Project Structure](#project-structure)

### Prerequisites

-   <img src="readme/assets/php.svg" width="35" style="position: relative; top: 4px" /> *PHP@8.1 and up*
-   <img src="readme/assets/mysql.png" width="35" style="position: relative; top: 4px" /> _MYSQL@8 and up_
-   <img src="readme/assets/composer.png" width="35" style="position: relative; top: 6px" /> _composer@2.5 and up\_

### Tech Stack

-   <img src="readme/assets/laravel.png" height="18" style="position: relative; top: 4px" /> [Laravel@11](https://laravel.com/docs/6.x) - web application framework
-   <img src="readme/assets/reverb.png" height="22" style="position: relative; top: 4px" /> [Reverb@beta](https://reverb.laravel.com/) - first-party WebSocket server for Laravel applications.

### Getting Started

1\. First of all you need to clone Blaze-back repository from github:

```sh
git clone https://github.com/GeekoIsaGeek/blaze-back
```

2\. Next step requires you to run _composer install_ in order to install all the dependencies.

```sh
composer install
```

3\. Now we need to set our env file. Go to the root of your project and execute this command.

```sh
cp .env.example .env
```

And now you should provide **.env** file all the necessary environment variables:

**MYSQL:**

> DB_CONNECTION=mysql

> DB_HOST=127.0.0.1

> DB_PORT=3306

> DB_DATABASE=**\***

> DB_USERNAME=**\***

> DB_PASSWORD=**\***

###

**Reverb:**

> BROADCAST_DRIVER=reverb

> REVERB_APP_ID=**\***

> REVERB_APP_KEY=**\***

> REVERB_APP_SECRET=**\***

> REVERB_HOST=**\***

> REVERB_PORT=**\***

> REVERB_SCHEME=**\***

###

after setting up **.env** file, execute:

```sh
php artisan config:cache
```

in order to cache environment variables.

Now execute in the root of you project following:

```sh
  php artisan key:generate
```

If you are using public disk to make stored files publicly accessible, run:

```sh
  php artisan storage:link
```

Which generates auth key.

##### Now, you should be good to go!

### Migration

if you've completed getting started section, then migrating database if fairly simple process, just execute:

```sh
php artisan migrate
```

### Seeding

it's important to run InterestSeeder to fill interests table with relevant data:

```sh
php artisan db:seed --class=InterestSeeder
```

### Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

To run a WebSocket server, execute:

```sh
  php artisan reverb:start
```

### Project Structure

```bash
├─── app
│   ├─── Broadcasting
│   ├─── Console
│   ├─── Enums
│   ├─── Events
│   ├─── Exceptions
│   ├─── Helpers
│   ├─── Http
│   ├─── Models
│   ├─── Providers
│   │... Services
├─── bootstrap
├─── config
├─── database
├─── lang
├─── public
├─── readme
├─── resources
├─── routes
├─── storage
├─── tests
- .env
- artisan
- composer.json
- package.json
- phpunit.xml
- README.md
- vite.config.js

```

[Database Design Diagram](https://drawsql.app/teams/geekoisageek/diagrams/blaze)
