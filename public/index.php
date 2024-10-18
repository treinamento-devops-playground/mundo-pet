<?php

use core\Router;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// dd($_SERVER);
// dd(RequestType::get());

try {
  Router::run();
} catch (Exception $e) {

  echo "Ocorreu um erro: " . $e->getMessage();
}
