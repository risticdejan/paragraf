<?php

namespace Core\Database;

class Connaction {

    private static $conn;

    private function __construct(){}
    private function __clone() {}

    public static function getInstance(){
        if(self::$conn === null){
            self::$conn = self::getConnect();
        }

        return self::$conn;
    }

    private static function getConnect(){
        $conn = new \PDO(DB_DNS, DB_USERNAME, DB_PASSWORD);

        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $conn->exec("set names utf8");
        
        return $conn;     
    }
    
}