<?php

namespace App\Service;

use App\Model\Osiguranik as Osiguranik;
use App\Repository\OsiguranikRepository as OsiguranikRepository;

class OsiguranikService {

    private $osiguranikRepo;

    public function __construct(){
        $this->osiguranikRepo = new OsiguranikRepository();
    }

    public function getNosioca($id){
        return $this->osiguranikRepo->getNosioca($id);
    }

    public function getNosiocaSaOsiguranicima($id) {
        return $this->osiguranikRepo->getOsiguranike($id);
    }
}



