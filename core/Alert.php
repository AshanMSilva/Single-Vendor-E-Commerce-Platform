<?php
    class Alert{
        public static function set($alert){
            Session::set('alert',$alert);
        }
        public static function displaybootstrapalert(){
            if(Session::exists('alert')){
                $alert = Session::get('alert');
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                echo $alert;
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
                self::delete();
            }
        }
        public static function displayscriptalert(){
            if(Session::exists('alert')){
                $alert = Session::get('alert');
                echo '<script>';
                echo 'alert("'.$alert.'");';
                echo '</script>';
                self::delete();
            }
        }
        public static function delete(){
            Session::delete('alert');
        }
    }