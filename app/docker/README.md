# Docker Directory

Here lies the docker-compose file for the application and its other configurations.
The entire app is containerized using docker and orchestrated using docker-compose.
To run the application, you must have docker and docker-compose installed on your machine.

## Prerequisites

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Running the Application

To run the application, simply run the following command from this directory:

```bash
docker compose up -d
```

...or if you prefer it to run from the root directory of the project, don't forget to add
the `-f` flag to specify the docker-compose file:

```bash
docker compose -f app/docker/docker-compose.yml up -d
```

## Services

The app consists of 3 services:

- [mssql](#mssql): This is the database service.
- [nginx](#nginx): This is the reverse proxy service.
- [php-fpm](#php-fpm): This is the application service.

### mssql

This is the database service. It uses the latest Microsoft SQL Server image from Docker Hub.
The database is initialized using the [schema](../schema/README.md) folder.

### nginx

This is the reverse proxy service. It uses the latest nginx image from Docker Hub.
This is what serves the application inside the [core](../core/README.md) folder.

### php-fpm

This is the application service. It uses the latest php-fpm image from Docker Hub.
This is used to interpret the PHP code inside the [core](../core/README.md) folder
through the [nginx](#nginx) service.