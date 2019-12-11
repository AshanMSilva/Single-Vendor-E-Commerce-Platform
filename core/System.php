<?php
    class System{
        public static function sendmail($email,$subject,$message){
            $header = "From: ashansilva.17@cse.mrt.ac.lk";
            if(mail($email,$subject,$message,$header)){
                return true;
            }
            else{
                return false;
            }
        }

        public static function verifypassword($password,$repassword){
            if($password==$repassword){
                return true;
            }
            else{
                return false;
            }
        }
        public static function encrypt($name){
            return sha1($name);
        }
        public static function generaterandcode(){
            return substr(str_shuffle("0123456789"),0,5);
        }
    }