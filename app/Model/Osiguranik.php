<?php

namespace App\Model;

class Osiguranik {

    private $table = 'osiguranici';

    private $id;
    private $puno_ime;
    private $datum_rodjenja;
    private $broj_pasosa;

    public function __construct(){}

    public function getTable(){
        return $this->table;
    }

    public function getId(){
        return $this->id;
    }

    public function getPunoIme(){
        return $this->puno_ime;
    }

    public function setPunoIme($puno_ime){
        $this->puno_ime = $puno_ime;
    }

    public function getDatumRodjenja(){
        return $this->datum_rodjenja;
    }

    public function setDatumRodjenja($datum_rodjenja){
        $this->datum_rodjenja = $datum_rodjenja;
    }

    public function getBrojPasosa(){
        return $this->broj_pasosa;
    }

    public function setBrojPasosa($broj_pasosa){
        $this->broj_pasosa = $broj_pasosa;
    }
}

