<?php

define("BASE_URL","http://localhost/vhosts/paragraf");
define("BASE_PATH",__DIR__);
define("APP_PATH", __DIR__ . "/app");
define("CORE_PATH", __DIR__ . "/core");
define("VIEW_PATH", __DIR__ . "/app/View");

define("DB_DNS", "mysql:host=localhost;dbname=paragraf");
define("DB_USERNAME",  "root");
define("DB_PASSWORD", "");

define("MAIL_HOST","smtp.gmail.com");
define("MAIL_PORT","587");
define("MAIL_USERNAME","dejanrr77@gmail.com");
define("MAIL_PASSWORD","story26okt77");
define("MAIL_ENCRYPTION","tls");
define("MAIL_FROM_ADDRESS","dejanrr77@gmail.com");
define("MAIL_FROM_NAME","dejan");

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

