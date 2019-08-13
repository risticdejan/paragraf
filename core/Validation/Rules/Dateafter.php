<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Dateafter extends Rule {

    private $param;

    private $message = 'Datum mora biti posle ';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        if($value == "") return false;

        return strtotime($value) >= strtotime($this->param);
    }

    public function getErrorMessage() {
        return $this->message.date('Y/m/d',strtotime($this->param));
    }
}
