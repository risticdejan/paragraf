<?php

namespace Core;

class Session {

    private static function start() {
        if(!isset($_SESSION)) {
            session_start();
        }
    }

    public static function set($key, $value){
        self::start();

        $_SESSION[$key] = $value;
    }

    public static function has($key) {
        self::start();

        return isset($_SESSION[$key]);
    }

    public static function get($key) {
        if(self::has($key)) {
            if(is_array($_SESSION[$key])) {
                foreach($_SESSION[$key] as $k => $v){
                    $tmp[$k] = htmlspecialchars($v);
                }
                return $tmp;
            }
            return htmlspecialchars($_SESSION[$key]);
        }

        return '';
    }

    public static function clear($key) {
        if(self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        self::start();

        foreach($_SESSION as $k => $v) {
            unset($_SESSION[$k]);
        }

        setcookie(session_name(),'',0,'/');
        
        session_destroy();
    }
}