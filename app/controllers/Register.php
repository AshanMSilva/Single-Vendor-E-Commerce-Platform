<?php
    class Register extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        
        public function loginAction(){
           // dnd($this->_action);
            if(isset($_POST['submit'])){
                $email = Input::get('email');
                $password =Input::get('password');

                //get email from database

                if($email =='ashan'){

                    //get password from database

                    /*if(System::verifypassword(sha1($password),put password here){
                        Alert::set('Welcome Back'); 
                        Router::redirect('home/registerlogged');
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
                    
                }
                else{
                    Alert::set('email is incorrect'); 
                   // Session::set('logged',true);
                   Router::redirect('home/index');
                   
                }
                
                
                //dnd($_POST);
            }
            else{
                //dnd($_POST);
            }
            
        }
        public function signupAction(){
            if(isset($_POST['submit'])){
                $signupdetails= $_POST;
                $password =Input::get('password');
                $repassword =Input::get('re-password');
                if(System::verifypassword($password,$repassword)){
                    $signupdetails['password']=System::encrypt($password);
                    $signupdetails['re-password'] =null;
                    Session::set('signupdetails',$signupdetails);
                    //$url = 'email/validate?email='.$email;
                    //dnd($signupdetails);
                    Router::redirect('email/validate');
                }
                else{
                    $script ='$(window).on("load",function(){
                        $("#loginModal").modal("show");
                    });';
                    Alert::set('Please enter same password in both places');
                    Script::set($script);
                    Router::redirect('home/index');
                }
                
               
            }
        }
        //public function guestAction(){
        //    Alert::set('Successfully logged as a guest..!'); 
        //    Router::redirect('home/guestlogged');
        //}
        public function forgotpasswordAction(){

        }
    }