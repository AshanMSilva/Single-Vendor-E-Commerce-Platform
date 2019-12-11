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
                $randcode=$System::generaterandcode();
                Session::set('randcode',$randcode);
                $email=$_POST['email'];
                System::sendmail($email,$randcode);
                $script ='$(window).on("load",function(){
                    $("#verficationCodeModal").modal("show");
                });';
                Script::set($script);
                Router::redirect('email/validate');
                //dnd($_SESSION);
            }

        }
        public function verifycodeAction(){
            if(isset($_POST['submit'])){
                $code =$_POST['code'];
                if(Session::exists('randcode')){
                    $randcode= Session::get('randcode');
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
                        Session::delete('randcode');
                        Alert::set('Your input code is incorrect. Please click send button to send verification code again..! ');
                    }
                }

            }
        }
    }