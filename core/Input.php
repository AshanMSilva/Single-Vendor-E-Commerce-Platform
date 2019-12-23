<?php
    class Input{
<<<<<<< HEAD
        public static function sanitize($dirty){
            return htmlentities($dirty,ENT_QUOTES,"UTF-8");
        }
=======
        
        public static function sanitize($dirty){
            return htmlentities($dirty,ENT_QUOTES,"UTF-8");
        }

>>>>>>> model-sample
        public static function get($input){
            if(isset($_POST[$input])){
                return self::sanitize($_POST[$input]);
            }
            elseif(isset($_GET[$input])){
                return self::sanitize($_GET[$input]);
            }
        }
<<<<<<< HEAD
=======

        public static function get_array($input = []){
            $input_array = [];
            foreach($input as $key => $val){
                if($key != 'submit'){                           //name of the submit button
                    $input_array[$key] = self::sanitize($val);
                }
            }
            return $input_array;
        }
>>>>>>> model-sample
    }