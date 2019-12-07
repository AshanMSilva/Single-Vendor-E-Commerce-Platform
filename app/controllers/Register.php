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

        }
        public function guestAction(){

        }
    }