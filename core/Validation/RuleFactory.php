<?php 

namespace Core\Validation;

class RuleFactory {

    public static function make($strRule) {
        $arr = explode(':',$strRule);

        $ruleClassName = 'Core\Validation\Rules\\'.ucfirst($arr[0]);
        $param = isset($arr[1])? $arr[1] : "";

        if(class_exists($ruleClassName)){
            return new $ruleClassName($param);
        } else {
            exit('there is no class with name '.$ruleClassName);
        }
    }
}

