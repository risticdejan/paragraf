<?php

namespace App\Model;

class Polisa {

    public $id;
    public $nosioc;
    public $datum_polaska;
    public $datum_dolaska;
    public $tip_polise;
    public $datum_unosa;

    public function __construct(
        $nosioc = null, $datum_polaska = '',
        $datum_dolaska = '', $tip_polise = 1
    ){
        $this->nosioc = $nosioc;
        $this->datum_polaska = $datum_polaska;
        $this->datum_dolaska = $datum_dolaska;
        $this->tip_polise = $tip_polise;
    }

}