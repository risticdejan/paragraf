<?php

namespace Core;

class Request {

    private $inputs;

    private $headers;

    private static $instance;

    private function __construct(){
        $this->inputs = $this->fill($_REQUEST);
        $this->headers = $this->fill($_SERVER);
    }

    private function __clone() {}

    private function fill($arr){
        $data = [];
        foreach($arr as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }

    private function get($key, $src){
        if(is_array($key)){
            $arr = [];
            foreach($key as $k => $v){
                if(array_key_exists($key, $src))
                $arr[$v] = $src[$v];
            }
            return $arr;
        }

        return array_key_exists($key, $src) 
                    ? $src[$key] 
                    : null;
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function input($key = ''){
        $instance = self::getInstance();

        if($key === '') return $instance->inputs;

        return $instance->get($key, $instance->inputs);
    }

    public static function header($key = ''){
        $instance = self::getInstance();

        if($key === '') return $instance->headers;

        return $instance->get($key, $instance->headers);
    }

    public static function getMethod(){
        return  self::header('REQUEST_METHOD');
    }

    public static function getUri(){
        $uri = substr(
            rawurldecode(self::header('REQUEST_URI')), 
            strlen(self::getBasePath())
        );

        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return '/' . trim(self::getBasePath().$uri, '/');
    }

    public static function getUrl(){
        return self::header('REQUEST_SCHEME')
                    ."://"
                    .self::header('HTTP_HOST')
                    .self::getUri();
    }

    public static function getBasePath(){
        return implode(
            '/', 
            array_slice(
                explode(
                    '/', 
                    self::header('SCRIPT_NAME')
                ), 
                0, 
                -1
            )
        );
    }

    public static function is($path){
        $uri = substr(
            rawurldecode(self::header('REQUEST_URI')), 
            strlen(self::getBasePath())
        );

        return $uri === $path;
    }
}

