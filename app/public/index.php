<?php
require '../vendor/autoload.php';

const DEFAULT_PROFILE = 'blankPerson.png';

$url = $_SERVER['REQUEST_URI'];

$router = new App\Router();
$router->route($url);
