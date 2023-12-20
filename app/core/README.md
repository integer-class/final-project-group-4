# Backend

Everything here is made closely to aspnetcore and laravel. The routing is annotation based just like 
how aspnetcore does it and the rest follows similar patterns to laravel.
The project is using a simplified version of the clean architecture. The project is split into several layers:

- `Business` - This is where the business logic is, the core logic of the app you could say.
- `Presentation` - This is where the controllers are, how the data are presented to the users.
- `Primitives` - Every layer share the same primitives, this is where the models are.
- `Repository` - This is where the repository is, the repository is responsible for fetching data from the database.
- `RepositoryInterfaces` - This is where the repository interfaces are, the repository interfaces are responsible for defining the repository so that it's easy to change the repository implementation.

The `autoload.php` file contains the autoloader for the project, it's responsible for loading all the classes in the project.
The project follows the PSR-4 standard for autoloading its namespaces.