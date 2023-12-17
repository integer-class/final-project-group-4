<?php

require_once __DIR__ . "/autoload.php";

use Business\Services\AuthService;
use Business\Services\EventService;
use Business\Services\RoomService;
use Business\Services\UserService;
use Presentation\Http\Controllers\AdminViewController;
use Presentation\Http\Controllers\AppController;
use Presentation\Http\Controllers\ApproverViewController;
use Presentation\Http\Controllers\AuthController;
use Presentation\Http\Controllers\EventController;
use Presentation\Http\Controllers\RoomController;
use Presentation\Http\Controllers\UserController;
use Presentation\Http\Controllers\StudentViewController;
use Presentation\Http\Helpers\Session;
use Presentation\Http\HttpPresenter;
use Repository\EventRepository;
use Repository\MssqlClient;
use Repository\RoomRepository;
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

$httpPresenter = null;

if (!isset($_ENV["APP_HAS_INITIALISED"])) {
    $_ENV["APP_HAS_INITIALISED"] = true;

    // singletons
    $dbClient = MssqlClient::getInstance(
        host: getenv("DB_HOST"),
        port: getenv("DB_PORT"),
        database: getenv("DB_DATABASE"),
        username: getenv("DB_USERNAME"),
        password: getenv("DB_PASSWORD")
    );
    $session = Session::getInstance();

    // repositories
    $userRepository = new UserRepository($dbClient);
    $roomRepository = new RoomRepository($dbClient);
    $eventRepository = new EventRepository($dbClient);

    // services
    $authService = new AuthService($userRepository);
    $userService = new UserService($userRepository);
    $roomService = new RoomService($roomRepository);
    $eventService = new EventService($eventRepository);

    // controllers
    $userController = new UserController($userService);
    $roomController = new RoomController($roomService);
    $authController = new AuthController($authService, $session);
    $eventController = new EventController($eventService);

    // view controllers
    $appController = new AppController($session);
    $adminViewController = new AdminViewController($session, $userService, $roomService, $eventService);
    $studentViewController = new StudentViewController($session, $roomService, $eventService);
    $approverViewController = new ApproverViewController($session, $roomService, $eventService);

    $httpPresenter = new HttpPresenter();

    // register controllers
    $httpPresenter->register($userController);
    $httpPresenter->register($appController);
    $httpPresenter->register($authController);
    $httpPresenter->register($roomController);
    $httpPresenter->register($eventController);
    $httpPresenter->register($adminViewController);
    $httpPresenter->register($studentViewController);
    $httpPresenter->register($approverViewController);
}

// handle request
$httpPresenter->run();
