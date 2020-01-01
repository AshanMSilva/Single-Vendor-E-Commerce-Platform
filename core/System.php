<?php
    class System{
        public static function sendmail($email, $subject, $message){
            $header = "From: ashansilva.17@cse.mrt.ac.lk";
            if(mail($email, $subject, $message, $header)){
                return true;
            }
            else{
                return false;
            }
        }

        public static function email_exists($email){
            $db = DB::getInstance();
            $results_obj = $db->query("SELECT customer_id FROM registered_customers WHERE email = ?", [$email]);
            $row_count = $results_obj->get_row_count();
            // dnd($row_count);
            if($row_count){
                return true;
            }
            else{
                return false;
            }
        }
    
        public static function verify_password($email, $password){
            $db = DB::getInstance();
            $results_obj = $db->query("SELECT password FROM registered_customers WHERE email = ?", [$email]);
            if($results_obj->get_row_count() == 1){
                //dnd($results_obj->results());
                $hash = $results_obj->results()[0]->password;
                //dnd($hash);
                // return $password == $hash;
                return password_verify($password, $hash);      // built-in method. hash should be generated by password_hash method
            }
        }
    
        public static function validate_password($password){
            $pattern = '/^(?=.*[!@#$%^&*+=-_\/><.,:;])(?=.*[0-9])(?=.*[A-Z]).{6,}$/';
            if (preg_match($pattern, $password)){
                if(!preg_match('/\s/', $password) && !preg_match('/\'/', $password) && !preg_match('/\"/', $password)){
                    // dnd("true");
                    return true;
                }
                else{
                    Alert::set('Whitespaces & Quotation marks are not allowed in the password');
                    return false;
                }                
            }
            else{
                // Alert::set('Password does not match the required security level. Follow the tips shown at the form.');
                return false;
            }
        }

        /*public static function verifypassword($password,$repassword){
            if($password==$repassword){
                return true;
            }
            else{
                return false;
            }
        }*/

        public static function encrypt($name){
            return sha1($name);
        }

        public static function generaterandcode(){
            return substr(str_shuffle("0123456789"),0,5);
        }

        public static function calc_delivery_estimate($cart_products, $city = null){
            $delivery_time = 5;
            
            if($city != null){
                $db = DB::getInstance();
                $count = $db->select_count('main_cities', '*', [
                    'conditions' => 'city = ?',
                    'bind' => [$city]
                ]);
                // dnd($count);
                if(!$count){
                    $delivery_time += 2;
                }
            }
            // dnd($delivery_time);         
            
            foreach($cart_products as $product){
                $variant_obj = $product['product_obj']->get_variants()[0];
                // dnd($variant_obj);
                $stock = intval($variant_obj->get_stock());
                // dnd($stock);
                $quantity = $product['quantity'];                
                if($stock < $quantity){
                    $delivery_time += 3;
                    // echo $delivery_time;
                    break;
                }
            }
            // dnd($delivery_time);
            $date = date('Y/m/d', strtotime(' + ' . $delivery_time .' days'));
            // dnd($date);
            return $date;
        }

        public static function get_all_categories($root_objs, $cat_array){
            foreach($root_objs as $obj){
                if($obj->has_sub_category()){
                    $sub_cat_objs = $obj->get_sub_categories();
                    $cat_array[$obj->get_title()] = self::get_all_categories($sub_cat_objs, []);
                }
                else{
                    $cat_array[$obj->get_title()] = $obj->get_category_id();
                }
            }
            return $cat_array;
        }
    }