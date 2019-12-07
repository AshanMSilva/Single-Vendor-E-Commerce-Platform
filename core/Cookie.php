<?php
    class Cookie{
        public static function set($name,$value,$expiry){
            if(setcookie($name,$value,time()+$expiry,'/')){
                return true;
            }
            else{
                return false;
            }
        }
        public static function delete($name){
            self::set($name,'',time()-1);
        }
        public static function get($name){
            return $_COOKIE[$name];
        }
        public static function exists($name){
            if(isset($_COOKIE[$name])){
                return true;
            }
            else{
                return false;
            }
        }
    }