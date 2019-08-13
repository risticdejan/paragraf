<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Required extends Rule {

    private $param;

    private $message = 'Polje je obavezno';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        return !empty($value);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}

