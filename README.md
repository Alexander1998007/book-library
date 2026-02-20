# Book library

This is a Laravel 12 application set up with Docker, using migrations, seeders, and factories. It also includes Laravel Sanctum for API authentication and L5 Swagger for API documentation.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Docker Setup](#docker-setup)
- [Environment Configuration](#environment-configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Running Tests](#running-tests)
- [API Documentation](#api-documentation)
- [Additional Notes](#additional-notes)
- [Quick Setup Summary (Docker + Composer)](#quick-setup-summary-docker--composer)

---

## Requirements

Make sure you have the following installed on your system:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

> PHP, Composer, and Node.js are handled via Docker.

---

## Installation

Clone the repository:

```bash
git clone <https://github.com/Alexander1998007/book-library.git> book-library

cd book-library
```

Install PHP dependencies via Composer:

```bash
docker exec -it book-library-app composer install
```

## Docker Setup

This project runs fully inside Docker. Start all services:

```bash
docker-compose up -d
```

This will start:

* **app** – PHP-FPM container
* **webserver** – Nginx container, exposing port 8083
* **db** – MySQL container, exposing port 3309

Check running containers:

```bash
docker ps
```

## Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key (inside the container):

```bash
docker exec -it book-library-app php artisan key:generate
```

Edit .env as needed, especially database credentials, e.g.:

```ini
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=book-library
DB_USERNAME=book-library
DB_PASSWORD=root
```

> Note: **DB_HOST=db** matches the service name in Docker Compose.

## Database Setup

Run migrations and seed the database (inside the container):

```bash
docker exec -it book-library-app php artisan migrate:fresh --seed
```

This will:

* Drop all existing tables
* Recreate them using your migration files
* Populate tables with seed data using your factories and seeders

## Running the Application

Once Docker is up, access your application via Nginx at:

```bash
http://localhost:8083
```

For development mode with live reload and automatic asset compilation, enter the **app** container shell:

```bash
docker exec -it book-library-app bash
composer dev
```

This runs:

* PHP server for Laravel commands
* Queue listener
* Log tailing
* Vite dev server for frontend assets

## Running Tests

Run your PHPUnit tests inside the container:

```bash
docker exec -it book-library-app composer test
```

This clears configuration cache and executes your test suite.

## API Documentation

This project uses L5 Swagger. Access the Swagger UI at:

```bash
http://localhost:8083/api/documentation
```

Regenerate documentation if needed:

```bash
docker exec -it book-library-app php artisan l5-swagger:generate
```

## Additional Notes

* All Composer scripts (**setup**, **dev**, **test**) are preconfigured for common tasks
* Factories and seeders ensure your tables have initial data for development
* Sanctum is used for API authentication; configure tokens in **.env**
* Node dependencies are handled inside the container with **npm install** and built with **npm run build**

## Quick Setup Summary (Docker + Composer)

```bash
git clone https://github.com/Alexander1998007/book-library.git
cd book-library
docker-compose up -d
docker exec -it book-library-app composer install
docker exec -it book-library-app php artisan key:generate
docker exec -it book-library-app php artisan migrate:fresh --seed
# visit http://localhost:8083
```
