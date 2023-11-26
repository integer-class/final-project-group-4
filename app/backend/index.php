<?php

require_once __DIR__ . "/autoload.php";

use Presentation\Http\Controllers\AppController;
use Presentation\Http\Controllers\UserController;
use Presentation\Http\HttpPresenter;
use Repository\MssqlClient;
use Repository\UserRepository;

// reads environment from .env file and sets it to the $_ENV superglobal
$env = file_get_contents(__DIR__ . "/.env");
$lines = explode("\n", $env);

foreach ($lines as $line) {
    preg_match("/([^#]+)=(.*)/", $line, $matches);
    if (isset($matches[2])) {
        putenv(trim($line));
    }
}

// sets the timezone
date_default_timezone_set(getenv("TIMEZONE"));

// initialise and register http presenter on first request, this is like a lazy singleton since we can't really execute
// code before any request has been made

$http_presenter = null;

if (!isset($_ENV["APP_HAS_INITIALISED"])) {
    $_ENV["APP_HAS_INITIALISED"] = true;

    $db_client = MssqlClient::getInstance(getenv("DB_HOST"),
        getenv("DB_PORT"),
        getenv("DB_DATABASE"),
        getenv("DB_USERNAME"),
        getenv("DB_PASSWORD"));

    // repositories
    $user_repository = new UserRepository($db_client);

    // controllers
    $app_controller = new AppController();
    $user_controller = new UserController($user_repository);

    $http_presenter = new HttpPresenter();

    // register controllers
    $http_presenter->register($user_controller);
    $http_presenter->register($app_controller);
}

// handle request
$http_presenter->run();
