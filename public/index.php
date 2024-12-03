<?php

use core\Router;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

use app\database\Connection;


Connection::createDatabase();

session_start();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// dd($_SERVER);
// dd(RequestType::get());

$container = require __DIR__ . '/../config/container.php';

try {
  Router::run($container);
} catch (Exception $e) {

  echo "Ocorreu um erro: " . $e->getMessage();
}
