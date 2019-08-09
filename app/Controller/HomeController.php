<?php

namespace App\Controller;

use Core\Controller\BaseController as BaseController;
use Core\Request as Request;

class HomeController extends BaseController{
    public function index() {

        echo $this->render('home.php');
    }
}