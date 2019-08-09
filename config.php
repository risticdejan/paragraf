<?php

define("BASE_URL","http://localhost/vhosts/paragraf");
define("BASE_PATH",__DIR__);
define("APP_PATH", __DIR__ . "/app");
define("CORE_PATH", __DIR__ . "/core");

define("DB_DNS", "mysql:host=localhost;dbname=paragraf");
define("DB_USERNAME",  "root");
define("DB_PASSWORD", "");

define('ENVIRONMENT','development');

switch (ENVIRONMENT)
{
    case 'development':
        define("DEBUG", TRUE);
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        define("DEBUG", FALSE);
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Aplikaciono okruženje nije podešeno ispravno.';
        exit(1);
}

