<?php
    class Session{
        public static function exists($name){
            if(isset($_SESSION[$name])){
                return true;
            }
            else{
                return false;
            }
        }
        public static function get($name){
            return $_SESSION[$name];
        }
        public static function set($name,$value){
            $_SESSION[$name] =$value;
        }
        public static function delete($name){
            if(self::exists($name)){
                // dnd("delete fn");
                unset($_SESSION[$name]);
                // dnd($_SESSION);
            }
        }
        public static function uagent_no_version(){ //to get information about login machine
            $uagent =$_SERVER['HTTP_USER_AGENT'];
            $regx = '/\/[a-zA-Z0-9.]+/';
            $newString = preg_replace($regx,'',$uagent);  //to remove browser version because it can be updated
            return $newString;
        }
    }