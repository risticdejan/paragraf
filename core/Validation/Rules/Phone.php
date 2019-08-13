<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Phone extends Rule {

    private $param;

    private $message = 'Telefonski broj nije ispravan';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        return (bool) preg_match('/^[0-9\-\(\)\/\+\s]*$/', $value);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}