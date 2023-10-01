<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

//https://dev.to/walternascimentobarroso/dotenv-in-php-45mn
//echo $_ENV['APP_ENV'];


$router = new Framework\Routing\Router();

$routes = require_once __DIR__ . '/../app/routes.php';

$routes($router);



print $router->dispatch();