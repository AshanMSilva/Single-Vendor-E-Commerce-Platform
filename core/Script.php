<?php
    class Script{
        public static function set($script){
            Session::set('script',$script);
        }
        
        public static function displayscript(){
            if(Session::exists('script')){
                $script = Session::get('script');
                //dnd($script);
                //dnd($_SESSION);
                echo '<script>';
                echo $script;
                echo '</script>';
                self::delete();
            }
            
        }
        public static function delete(){
            Session::delete('script');
        }
    }