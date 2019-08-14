<?php

namespace App\Model;

class Osiguranik {

    public $id;
    public $puno_ime;
    public $datum_rodjenja;
    public $broj_pasosa;
    public $telefon;
    public $email;

    public function __construct(
        $puno_ime = '', $datum_rodjenja = '', 
        $broj_pasosa = '',$email = null, $telefon = null
    ){
        $this->puno_ime = $puno_ime;
        $this->datum_rodjenja = $datum_rodjenja;
        $this->broj_pasosa = $broj_pasosa;
        $this->email = $email;
        $this->telefon = $telefon;
    }

    
}

