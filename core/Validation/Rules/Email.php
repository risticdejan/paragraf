<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Email extends Rule {

    private $param;

    private $message = 'Email nije ispravan';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}