<?php

namespace App\Service;

use App\Model\Osiguranik as Osiguranik;
use App\Model\Polisa as Polisa;
use App\Repository\OsiguranikRepository as OsiguranikRepository;
use App\Repository\PolisaRepository as PolisaRepository;

class PolisaService {

    private $osiguranikRepo;
    private $polisaRepo;

    public function __construct(){
        $this->osiguranikRepo = new OsiguranikRepository();
        $this->polisaRepo = new PolisaRepository();
    }

    public function create($request) {
        $nosioc = new Osiguranik(
            $request['puno_ime'],
            $request['datum_rodjenja'],
            $request['broj_pasosa'],
            $request['email'],
            empty($request['telefon'])? null : $request['telefon'] 
        );

        if(($nosioc = $this->osiguranikRepo->create($nosioc)) !== null){
            $polisa = new Polisa(
                $nosioc,
                $request['datum_polaska'],
                $request['datum_dolaska'],
                $request['tip_polise']
            );

            $polisa = $this->polisaRepo->create($polisa);

            if(!empty($request['osiguranik'])) {
                $osiguranici = $this->osiguranikRepo
                    ->createGrupnoOsiguraje($nosioc, $request['osiguranik']);
            }
        }

        return $polisa;
    }

    public function getAll(){
        return $this->polisaRepo->getAll();
    }
}



