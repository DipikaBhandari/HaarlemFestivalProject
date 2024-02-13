<?php
require '../vendor/autoload.php';

$url = $_SERVER['REQUEST_URI'];

$router = new App\Router();
$router->route($url);
