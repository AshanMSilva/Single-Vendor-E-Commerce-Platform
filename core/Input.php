<?php
    class Input{
        
        public static function sanitize($dirty){
            return htmlentities($dirty,ENT_QUOTES,"UTF-8");
        }

        public static function get($input){
            if(isset($_POST[$input])){
                return self::sanitize($_POST[$input]);
            }
            elseif(isset($_GET[$input])){
                return self::sanitize($_GET[$input]);
            }
        }

        public static function get_array($input = [], $buttons = []){
            $input_array = [];
            foreach($input as $key => $val){
                if(!in_array($key, $buttons)){                           // names of form buttons
                    $input_array[$key] = self::sanitize($val);
                }
            }
            return $input_array;
        }
    }