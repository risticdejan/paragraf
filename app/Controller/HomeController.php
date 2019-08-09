<?php

namespace App\Controller;

use Core\Controller\BaseController as BaseController;
use Core\Request as Request;

class HomeController extends BaseController{
    public function index() {
        echo $this->render('page/index.php');
    }

    public function list() {
        echo $this->render('page/list.php');
    }
}