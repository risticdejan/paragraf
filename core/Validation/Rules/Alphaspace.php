<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Alphaspace extends Rule {

    private $param;

    private $message = 'Polje je može da sadrži samo slova';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        return (bool) preg_match('/^[\p{L}\s]+$/u', $value);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}
