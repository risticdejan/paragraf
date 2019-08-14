<?php

namespace App\Controller;

use Core\Controller\BaseController as BaseController;       

class ErrorController extends BaseController{
    public function index() {
        echo $this->render('error/404.php');
    }
}