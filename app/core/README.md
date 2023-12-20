# Backend

Everything here is made closely to aspnetcore and laravel. The routing is annotation based just like
how aspnetcore does it and the rest follows similar patterns to laravel.
The project is using a simplified version of the clean architecture. The project is split into several layers:

- [Business](#Business) - This is where the business logic is, the core logic of the app you could say.
- [Presentation](#Presentation) - This is where the controllers are, how the data are presented to the users.
- [Primitives](#Primitives) - Every layer share the same primitives, this is where the models are.
- [Repository](#Repository) - This is where the repository is, the repository is responsible for fetching data from the
  database.
- [RepositoryInterfaces](#RepositoryInterfaces) - This is where the repository interfaces are, the repository interfaces
  are responsible for defining the repository so that it's easy to change the repository implementation.

The `autoload.php` file contains the autoloader for the project, it's responsible for loading all the classes in the
project.
The project follows the PSR-4 standard for autoloading its namespaces.

## Business

The business layer is where the business logic is, the core logic of the app you could say.
This is where all the services are, the services are responsible for handling the business logic of the app.

## Presentation

The presentation layer is where the controllers are, how the data are presented to the users.
Currently this project presents the data to the user through the web, hence it has the
`Http` folder. The `Http` folder contains the controllers and the middleware for the app.

It uses an annotation based routing system, the routes are defined in the controller classes
using the `Route` annotation. The `Route` annotation takes 2 parameters, the first parameter
is the path of the route and the second parameter is the HTTP method of the route.

It takes inspiration from [aspnetcore](https://docs.microsoft.com/en-us/aspnet/core/)
and [laravel](https://laravel.com/).

Each controller method is responsible for returning a response to the user, the response
can be a view, a json response, or a redirect response.

Every `POST` or `PUT` request must have a body attached to it. The controller will receive a
DTO (Data Transfer Object) that contains the data from the body of the request.

## Primitives

The primitives layer is where the models are. Every layer share the same primitives, this is where the models are.
The models are responsible for holding the data of the app.

It's basically just POJO (Plain Old Java Object), or rather, in this case, it should be
POPO (Plain Old PHP Object).

It shouldn't depend on any other layer since it is the most basic layer of the app.

## Repository

The repository layer is where the repository is, the repository is responsible for fetching data from the database.
The repository uses the [php-pdo](https://www.php.net/manual/en/book.pdo.php) extension to connect to the database.

Every repository should implements their respective repository interface from the
[RepositoryInterfaces](#RepositoryInterfaces) layer. This is to ensure that
the repository is easily replaceable.

## RepositoryInterfaces

The repository interfaces layer is where the repository interfaces are, the repository interfaces are responsible for
defining the repository so that it's easy to change the repository implementation.
