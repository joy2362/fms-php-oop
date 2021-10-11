<?php
namespace lib\session;

class session_management{
    public static function init(){
        if (session_id() == "") {
            session_start();
        }
    }

    public static  function set($key,$val){
        $_SESSION[$key]=$val;
    }

    public static function get($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public static function check($key){
        if (isset($_SESSION[$key])) {
            return true;
        }
        return false;
    }
    public static function destroy(){
        self::init();
        session_unset();
        session_destroy();
    }
}