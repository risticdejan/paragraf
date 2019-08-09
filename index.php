<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$router = new Core\Router\Router();

/*
\d+ = One or more digits (0-9)
\w+ = One or more word characters (a-z 0-9 _)
*/
$router->get('/', "App\Controller\HomeController@index");
$router->get('/pregled', "App\Controller\HomeController@list");

$router->setRoute404("App\Controller\ErrorController@index");;

// $router->get('/about', function () {
//     echo  "Hello form the about route";
// });

$router->run();


