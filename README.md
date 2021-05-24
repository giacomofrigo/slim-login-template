# slim-login-template
A simple, ready to use Slim 4 login template.
This template is based on PHP Slim 4 Framework, Doctrine ORM and PHP-DI/Slim-Bridge.
# Installation
Dowload this repository and run:
```
composer install
```
This command will download and install all the project dependecies.

# Project structure
The `public/index.php` file which is the only public file, simply execute the `bootstrap.php` file where the application is initialized.
The `config/settings.php` file contains some useful settings that can be customized (i.e. logger settings).

The routes are specified in the `config/routes.php` file. The routes simply redirect the request to the correct handler.
Routes handlers are specified inside controllers. Controllers perform actions like args check and then called the needed methods defined inside 
the services. The services actually communicate with the database and their role is to retrieve or store data on the database.

# Database
This template uses a MySQL database and Doctrine ORM in order to achieve data persistance.

Database configuration need to be specified in a `.env` file in the root directory. A `.env.example` file is provided.

# Authentication
The authentication is provided through PHP Sessions. A Slim middleware is placed on the routes that requires authentication.

The middleware automatically checks if the user is authenticated.

If the user is correctly logged in, the request pass through the middleware and reaches the route logic otherwise an Exception is raised and the corrispondent response is returned.

# Errors handling
Errors can be genereted through Exceptions: when an error occured we can simply raise a new Exception.

Exceptions are then catched by the error middleware and a response is returned to the client.

Custom exceptions can be easily added by creating a new classes that extends the `BaseException.php` class. 

# Logging
Logging is provided through the Monolog library. The monolog library implements the PSR-3 interface.

# Run
This skeleton provides an easy way to test the PHP application by executing a local PHP server and expose it over the port `5000`.
In order to test you can simply run:
```
composer start
```

