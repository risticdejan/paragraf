<?php

namespace Core\Validation\Rules;

use Core\Validation\Rule as Rule;

class Date extends Rule {

    private $param;

    private $message = 'Datum nije u ispravnom formatu(YYYY-MM-DD)';

    public function __construct($param = ''){
        $this->param = $param;
    }

    public function check($value="") {
        list($y, $m, $d) = array_pad(explode('-', $value, 3), 3, 0);
        return ctype_digit("$y$m$d") && checkdate($m, $d, $y);
    }

    public function getErrorMessage() {
        return $this->message;
    }
}
