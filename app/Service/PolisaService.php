<?php

namespace App\Service;

use App\Model\Osiguranik as Osiguranik;
use App\Model\Polisa as Polisa;
use App\Repository\OsiguranikRepository as OsiguranikRepository;
use App\Repository\PolisaRepository as PolisaRepository;

use Dompdf\Dompdf;

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

            if($polisa){
                if(!empty($request['osiguranik'])) {
                    $osiguranici = $this->osiguranikRepo
                        ->createGrupnoOsiguraje($nosioc, $request['osiguranik']);
                    $polisa->nosioc->setOsiguranici($osiguranici);
                }
    
                return $this->get($polisa->id);
            }
            return null;
        }

        return null;
    }

    public function getAll($col = 'datum_unosa', $order = 'desc'){
        $col = $this->cleanColParametar($col);
        $order = $this->cleanOrderParametar($order);

        return $this->polisaRepo->getAll($col, $order);
    }

    public function get($id){
        return $this->polisaRepo->get($id);
    }

    public function createPdf($html) {
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();

        return $dompdf->output();
    }

    private function cleanColParametar($col){
        $col = strtolower(trim($col));
        return (in_array($col,[
            'puno_ime', 'datum_rodjenja', 'broj_pasosa',
            'telefon', 'email', 'datum_polaska', 'datum_dolaska',
            'broj_dana', 'datum_unosa', 'tip_polise'
        ])) ? $col : 'datum_unosa';
    }

    private function cleanOrderParametar($order){
        $order = strtolower(trim($order));
        return (in_array($order,['asc','desc'])) ? $order : 'datum_unosa';
    }
}



