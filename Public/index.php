<?php
require '../App/autoload.php';

$router = new Core\Router();

$router->addRoute('', 'index', 'index');
$router->addRoute('search/{subject}', 'index', 'search');
$router->addRoute('search/{subject}/{sort}', 'index', 'search');
$router->addRoute('{sorte}/{page}', 'index', 'index');

$router->run();
