<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Passport extends Rule {

    private $param;

    private $message = 'Broj pasoš nije ispavan, sastoji se od 9 cifara';

    public function __construct($param = ''){
        $this->param = $param;
    }
    
    public function check($value="") {
        return (bool) preg_match('/^[0-9]{9}$/u', $value);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}
