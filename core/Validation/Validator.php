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

    private function add($rules){
        $attr = [];

        if(!is_array($rules) || empty($rules)) return $attr;

        foreach($rules as $k => $v){
            $attr[$k] = explode('|', $v);
        }

        return $attr;
    }

    private function validate(){
        foreach($this->attributes as $keyAttr => $arryRules){
            
                foreach($arryRules as $strRule){
                    $rule = RuleFactory::make($strRule);
                    $value = isset($this->fields[$keyAttr])? $this->fields[$keyAttr] : '';
                    if(!$rule->check($value)) {
                        $this->errors[$keyAttr] = $rule->getErrorMessage();
                        break;
                    }
                }
            
        }
    }

   

    public function print(){
        print_r($this->fields);
        print_r($this->attributes);
        print_r($this->errors);
    }
}