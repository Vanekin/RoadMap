<?php

require_once __DIR__ . '/../autoload.php';
use RoadMap\Router;

$routes = require_once __DIR__ . '/../src/routes.php';

$url = $_GET['url'] ?? '/';
$url = rtrim($url, '/');
if (empty($url)) {
    $url = '/';
}

$router = new Router($routes);
$router->dispatch($url);