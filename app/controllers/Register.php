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
                if($email =='ashan'){
                    Alert::set('email is incorrect');
                    //Session::set('logged',false);
                    Router::redirect('home/index');
                }
                else{
                    Alert::set('email is correct'); 
                   // Session::set('logged',true);
                   Router::redirect('home/registerlogged');
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