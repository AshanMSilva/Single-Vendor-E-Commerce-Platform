<?php
    class Email extends controller{
<<<<<<< HEAD
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
=======
        public function __construct($controller, $action){
            parent::__construct($controller, $action);
>>>>>>> model-sample

        }
        public function validateAction(){
            //if(isset($_POST['submit'])){
            //    $firstName =$_POST['email'];
                //dnd($_POST);
                //dnd($_SESSION);
<<<<<<< HEAD
            if(Session::exists('signupdetails')){
                
                $signupdetails=Session::get('signupdetails');
                $email=$signupdetails['email'];
                Session::set('email',$email);
=======
            if(Session::exists('signup_details')){
                
                $signup_details = Session::get('signup_details');
                $email = $signup_details['email'];
                Session::set('email', $email);
>>>>>>> model-sample
                $this->view->setLayout('normal');
                $this->view->render('email/validate');
            }
                
           // }
           // else{
           //     dnd($_POST);
           // }
            
        }
        public function sendAction(){
            if(isset($_POST['submit'])){
<<<<<<< HEAD
                $randcode=System::generaterandcode();
                Session::set('randcode',$randcode);
                $email=$_POST['email'];
                //dnd($_POST);
                if(System::sendmail($email,"",$randcode)){
=======
                $randcode = System::generaterandcode();
                Session::set('randcode', $randcode);
                $email = $_POST['email'];
                //dnd($_POST);
                $msg = "Verification Code: " . $randcode . " . Please use the given code to verify your email. Thank you for joining with C Stores.";
                // dnd($msg);

                if(System::sendmail($email, "E-mail Verification Process", $msg)){
>>>>>>> model-sample
                    $script ='$(window).on("load",function(){
                        $("#verficationCodeModal").modal("show");
                    });';
                    Script::set($script);
<<<<<<< HEAD
                    Alert::set('Verification code sent to your email address successfully ');
=======
                    Alert::set('Verification code is sent to your email address successfully');
>>>>>>> model-sample
                    Router::redirect('email/validate');
                }
                else{
                    Alert::set('An error occured while sending the email. Try re-sending the Verification Code. Check whether the email address is correct. Check your internet connection.');
                    Router::redirect('email/validate');
                }
                
                //dnd($_SESSION);
            }

        }
        public function verifycodeAction(){
<<<<<<< HEAD
            //dnd($_SESSION);
            //dnd($_POST);
            if(isset($_POST['submitcode'])){
                $code =$_POST['code'];
                //dnd($_SESSION);
                if(Session::exists('randcode')){
                    
                    $randcode= Session::get('randcode');
                    //dnd($code);
                    if($code==$randcode){
                        if(Session::exists('signupdetails')){
                            $signupdetails =Session::get('signupdetails');
                            //save data in database
                            Session::delete('signupdetails');
                            Alert::set('Welcome to our E-commerce Platform');
=======
            if(isset($_POST['submitcode'])){
                $code = $_POST['code'];
                //dnd($code);
                if(Session::exists('randcode')){
                    $randcode = Session::get('randcode');

                    if($code == $randcode){

                        if(Session::exists('signup_details')){
                            $signup_details = Session::get('signup_details');
                            // dnd($signup_details);
                            //save data in database
                            $reg_cust = new RegisteredCustomer($signup_details);
                            // dnd($reg_cust);
                            $reg_cust->insert_customer($signup_details);

                            Session::delete('randcode');
                            Session::delete('signup_details');
                            //dnd($_SESSION);
                            // dnd($reg_cust);
                            $id = $reg_cust->get_id();
                            Session::set('current_logged_in_customer', $id);
                            // dnd($_SESSION);
                            Alert::set('Welcome to C Stores E-Commerce Platform');
>>>>>>> model-sample
                            Router::redirect('home/registerlogged');
                        }
                    }
                    else{
<<<<<<< HEAD
                        //dnd(type($randcode));
                        Session::delete('randcode');
                        Alert::set('Your input code is incorrect. Please click send button to send verification code again..! ');
=======
                        Session::delete('randcode');
                        Alert::set('Your input code is incorrect. Please click send button to send verification code again..!');
>>>>>>> model-sample
                        Router::redirect('email/validate');
                    }
                }

            }
        }
    }