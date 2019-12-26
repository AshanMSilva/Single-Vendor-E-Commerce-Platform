<?php
    class Register extends Controller{

        public function __construct($controller, $action){
            parent::__construct($controller, $action);
        }
        
        public function loginAction(){

           // dnd($this->_action);
            if(isset($_POST['submit'])){
                // dnd($_POST);
                $email = Input::get('email');
                $password =Input::get('password');

                if(System::email_exists($email)){
                    if(System::verify_password($email, $password)){
                        Alert::set('LogIn Successful');
                        $reg_cust = RegisteredCustomer::create_reg_cust($email);
                        $id = $reg_cust->get_id();
                        Session::set('registered_customer', $id);

                        if(Session::exists('my_cart')){
                            $my_products = Session::get('my_cart');
                            // dnd($my_products);
                            $cart = new Cart();
                            foreach($my_products as $product){
                                // dnd($id);
                                $cart->add_product($product);
                            }
                            Session::delete('my_cart');                           
                        }
                        //get password from database

                        /*if(System::verifypassword(sha1($password),put password here){
                            Alert::set('Welcome Back'); 
                            Router::redirect('home/index');
                        }
                        else{
                            Alert::set('Password is incorrect');
                            $script ='$(window).on("load",function(){
                            $("#loginModal").modal("show");
                        });';
                            Script::set($script);
                            Router::redirect('home/index');
                        }*/
                        //Alert::set('email is correct');
                        //Session::set('logged',false);
                        
                        Router::redirect('home/index');
                    }
                    else{
                        Alert::set('Invalid Password');
                    }                    
                }
                else{
                    Alert::set('Invalid email'); 
                    // Session::set('logged',false);
                    Router::redirect('home/index');
                }                              
                //dnd($_POST);
            }
            else{
                //dnd($_POST);
                Router::redirect('home/index');
            }             
        }

        public function signupAction(){

            if(isset($_POST['submit'])){ 
                // dnd($_POST);               
                $post_array = Input::get_array($_POST, ['submit']);                
                // dnd($post_array);
                if(!System::email_exists($post_array['email'])){        
                    
                    if(System::validate_password($post_array['password'])){

                        // $signupdetails['password']=System::encrypt($password);
                        // $signupdetails['re-password'] =null;
                        //Session::set('signupdetails',$signupdetails);
                        //$url = 'email/validate?email='.$email;
                        //dnd($signupdetails);

                        if($post_array['password'] == $post_array['re-password']){
                            unset($post_array['re-password']);

                            // $password = $post_array['password'];
                            $post_array['password'] = password_hash($post_array['password'], PASSWORD_DEFAULT);
                            // $hash = $post_array['password'];
                            // dnd(password_verify("Sahan@123", $hash));
                            // dnd($post_array);
                            // dnd($_SESSION);
                            Session::delete('signup_details');
                            Session::set('signup_details', $post_array);
                            // dnd($_SESSION);                       
                            Router::redirect('email/validate');
                        }
                        else{
                            Alert::set('Password and Re-Password fields are not the same');
                            Router::redirect('home/index');
                        }                      
                    }
                    else{
                        $script ='$(window).on("load",function(){
                            $("#loginModal").modal("show");
                        });';
                        Alert::set('Password does not have the required security level');
                        Script::set($script);
                        Router::redirect('home/index');
                    }                   
                    //Router::redirect('email/validate');
                    //load view of email validation
                }
                else{
                    Alert::set("There's an account for the email you entered");
                    Router::redirect('home/index');
                }
                //$signupdetails= $_POST;
                // $password =Input::get('password');
                // $repassword =Input::get('re-password');                           
               
            }
        }

        //public function guestAction(){
        //    Alert::set('Successfully logged as a guest..!'); 
        //    Router::redirect('home/guestlogged');
        //}

        public function forgotpasswordAction(){

        }
    }