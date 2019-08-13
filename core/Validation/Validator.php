<?php

namespace Core\Validation;

class Validator {

    private $fields = [];
    private $attributes = [];
    private $errors = [];

    public function __construct($fields, $rules){
        $this->fields = $fields;
        $this->attributes = $this->add($rules); 
        $this->validate();
    }

    public function isValid() {
        return empty($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }

    private function add($rules){
        $attr = [];

        if(!is_array($rules) || empty($rules)) return $attr;

        foreach($rules as $k => $v){
            
            if(is_array($v)) {
                foreach($v as $keyAdd => $valueAdd){
                    foreach ($valueAdd as $krule => $vrule) {
                        $attr[$k][$keyAdd][$krule] =  $vrule;
                    }
                }
               
            } else {
                $attr[$k] = $v;
            }
        }

        return $attr;
    }

    private function validate(){
        foreach($this->attributes as $keyAttr => $strRules){
            if(is_array($strRules)) {
                foreach ($strRules as $key => $rules) {
                    foreach ($rules as $krule => $vrule) {

                        $arrRules = explode('|', $vrule);
                
                        foreach($arrRules as $str){           
                            $rule = RuleFactory::make($str);
                            $value = isset($this->fields[$keyAttr][$key][$krule])? $this->fields[$keyAttr][$key][$krule] : '';
                            if (!$rule->check($value)) {
                                $this->errors[$keyAttr][$key][$krule] = $rule->getErrorMessage();
                                break;
                            }
                        }
                    }   
                }
            } else {
                $arrayRules = explode('|', $strRules);
                
                foreach($arrayRules as $strRule){           
                    $rule = RuleFactory::make($strRule);
                    $value = isset($this->fields[$keyAttr])? $this->fields[$keyAttr] : '';
                    if (!$rule->check($value)) {
                        $this->errors[$keyAttr] = $rule->getErrorMessage();
                        break;
                    }
                }
            }
        }
    }
    
    // public function print(){
    //     print_r($this->fields);
    //     print_r($this->attributes);
    //     print_r($this->errors);
    // }
}