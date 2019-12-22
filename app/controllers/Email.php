<?php
    class Email extends controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);

        }
        public function validateAction(){
            //if(isset($_POST['submit'])){
            //    $firstName =$_POST['email'];
                //dnd($_POST);
                //dnd($_SESSION);
            if(Session::exists('signupdetails')){
                
                $signupdetails=Session::get('signupdetails');
                $email=$signupdetails['email'];
                Session::set('email',$email);
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
                $randcode=System::generaterandcode();
                Session::set('randcode',$randcode);
                $email=$_POST['email'];
                //dnd($_POST);
                if(System::sendmail($email,"",$randcode)){
                    $script ='$(window).on("load",function(){
                        $("#verficationCodeModal").modal("show");
                    });';
                    Script::set($script);
                    Alert::set('Verification code sent to your email address successfully ');
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
                            Router::redirect('home/registerlogged');
                        }
                    }
                    else{
                        //dnd(type($randcode));
                        Session::delete('randcode');
                        Alert::set('Your input code is incorrect. Please click send button to send verification code again..! ');
                        Router::redirect('email/validate');
                    }
                }

            }
        }
    }