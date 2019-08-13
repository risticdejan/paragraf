<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Min extends Rule {

    private $param;

    private $message = 'Polje je kraće od %d karakera';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        if (is_numeric($value)) return FALSE;

        return mb_strlen($value) >= $this->param;
    }

    public function getErrorMessage() {
        return sprintf($this->message, $this->param);
    }
}