<?php

namespace App\Controller;

use Core\Controller\BaseController as BaseController;
use Core\Request as Request;
use Core\Validation\Validator as Validator;
use Core\Session as Session;
use App\Model\Osiguranik as Osiguranik;
use App\Model\Polisa as Polisa;
use App\Service\PolisaService as PolisaService;
use Core\Email as Email;

class HomeController extends BaseController{

    private $service;

    public function __construct(){
        $this->service = new PolisaService();
    }

    public function index() {
        $token = csrf_token();

        Session::set('token', $token);

        echo $this->render('page/index.php',[
            'token' => $token
        ]);
    }

    public function store(){
        if(Session::get('token') !== Request::input('token')) {
            $this->json([
                'error' => 'forbidden access'
            ], 403);
            die();
        }

        $rules = [
            'puno_ime' => 'required|alphaspace|min:4|max:64',
            'datum_rodjenja' => 'required|date|datebefore:'.date("Y-m-d"),
            'broj_pasosa' => 'required|passport',
            'telefon' => 'phone',
            'email' => 'required|email',
            'datum_polaska' => 'required|date|dateafter:'.date("Y-m-d"),
            'datum_dolaska' => 'required|date|dateafter:'.Request::input("datum_polaska"),
            'tip_polise' => 'required',
        ];

        if(Request::input('osiguranik') !== null) {
            foreach(Request::input('osiguranik') as $k => $v){
                $rules['osiguranik'][$k]['puno_ime'] = 'required|alphaspace|min:4|max:64';
                $rules['osiguranik'][$k]['datum_rodjenja'] = 'required|date|datebefore:'.date("Y-m-d");
                $rules['osiguranik'][$k]['broj_pasosa'] = 'required|passport';
            }
        }
        
        $validator = new Validator(Request::input(), $rules);

        if($validator->isValid()) {
            $polisa = $this->service->create(Request::input());

            if ($polisa) {
                $html = $this->render('prijava.php', ['polisa' => $polisa]);
                $pdf = $this->service->createPdf($html);

                Email::send(
                    $polisa->nosioc->email,
                    "pragraf:prijava", 
                    $this->render('email/prijava.php',['polisa' => $polisa]), 
                    $pdf,
                    'prijava.pdf'
                );

                Session::set('toast', [
                    'className' => 'success',
                    'message' => 'Uspešno je prijavljeno novo putno osiguranje'
                ]);
            } else {
                Session::set('toast', [
                    'className' => 'danger',
                    'message' => 'Nažalost, prijava nije uspela'
                ]);
            }

            $this->json([
                'status' => 'success',
                'url' => BASE_URL.'/pregled'
            ]);
        } else {
            $this->json([
                'status' => 'failed',
                'error' => $validator->getErrors()
            ]);
        }

    }

    public function list() {
        $col = !empty(Request::input('col')) 
            ? Request::input('col') : 'datum_unosa';
        $order = (Request::input('order') == 'desc')
            ? 'asc' : 'desc';

        $polise = $this->service->getAll($col, $order);

        echo $this->render('page/list.php',[
            'polise' => $polise,
            'col' => $col,
            'order' => $order
        ]);
    }
}