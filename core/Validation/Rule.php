<?php

namespace Core\Validation;

abstract class Rule {

    public abstract function check($value='');

    public abstract function getErrorMessage();
}

