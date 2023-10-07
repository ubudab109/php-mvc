<?php
require 'vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
require 'src/routes.php';
$router->dispatch($uri, $method);

