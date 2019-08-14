<?php

namespace App\Controller;

use Core\Controller\BaseController as BaseController;
use App\Service\OsiguranikService as OsiguranikService;

class OsiguranikController extends BaseController{

    private $service;

    public function __construct(){
        $this->service = new OsiguranikService();
    }

    public function nosioc($id) {
        $nosioc = $this->service->getNosioca($id);

        echo $this->render('page/nosioc.php',[
            'nosioc' => $nosioc
        ]);
    }

    public function grupno($id) {
        $nosioc = $this->service->getNosiocaSaOsiguranicima($id);

        echo $this->render('page/grupno.php',[
            'nosioc' => $nosioc
        ]);
    }
}