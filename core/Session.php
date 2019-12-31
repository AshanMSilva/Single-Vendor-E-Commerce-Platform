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

        public static function add_to_array($array_name, $value){
            if(self::exists($array_name)){
                $_SESSION[$array_name][] = $value;
            }
            else{
                $_SESSION[$array_name] = [$value];
            }
        }

        public static function update_array($array_name, $index, $key, $value){
            if(self::exists($array_name)){
                // dnd($_SESSION[$array_name][$index][$key]);
                $_SESSION[$array_name][$index][$key] = $value;
            }
        }

        public static function remove_from_array($array_name, $index){
            // dnd($_SESSION[$array_name]);
            if(self::exists($array_name)){
                unset($_SESSION[$array_name][$index]);
            }
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