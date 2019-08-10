<?php

namespace App\Controller;

use Core\Controller\BaseController as BaseController;
use Core\Request as Request;
use Core\Validation\Validator as Validator;
use Core\Session as Session;
use App\Model\Osiguranik as Osiguranik;
use App\Model\Polisa as Polisa;
use App\Repository\OsiguranikRepository as OsiguranikRepository;
use App\Repository\PolisaRepository as PolisaRepository;

class HomeController extends BaseController{
    private $osiguranikRepo;
    private $polisaRepo;

    public function __construct(){
        $this->osiguranikRepo = new OsiguranikRepository();
        $this->polisaRepo = new PolisaRepository();
    }

    public function index() {
        Session::set('dejan','majstor');

        echo $this->render('page/index.php');
    }

    public function store(){
        // print_r(Request::input());
        $validator = new Validator(Request::input(),[
            'puno_ime' => 'required',
            'datum_rodjenja' => 'required',
            'broj_pasosa' => 'required',
            'email' => 'required',
            'datum_polaska' => 'required',
            'datum_dolaska' => 'required',
            'tip_polise' => 'required',
        ]);

        if($validator->isValid()) {
            echo  'success';
        } else {
            $validator->print();
        }

        
        // $nosioc = new Osiguranik(
        //     Request::input('puno_ime'),
        //     Request::input('datum_rodjenja'),
        //     Request::input('broj_pasosa'),
        //     Request::input('telefon')
        // );

        // $polisa = new Polisa(
        //     $this->osiguranikRepo->create($nosioc),
        //     Request::input('email'),
        //     Request::input('datum_polaska'),
        //     Request::input('datum_dolaska'),
        //     Request::input('tip_polise')
        // );

        // $polisa = $this->polisaRepo->create($polisa);

        // print_r($polisa);
    }

    public function list() {
        Session::destroy();
        echo $this->render('page/list.php');
    }
}