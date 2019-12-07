<?php
    class Register extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        
        public function loginAction(){
           // dnd($this->_action);
            if(isset($_POST['submit'])){
                $email = $_POST['email'];
                $password =$_POST['password'];
                if($email=='ashan'){
                    Session::set('logged',false);
                }
                else{
                    Session::set('logged',true);
                }
                
                
                //dnd($_POST);
            }
            else{
                //dnd($_POST);
            }
            
            //$this->view->render('register/login');
            if(Session::exists('logged') && Session::get('logged')==true){
                //dnd($_SESSION);
                //dnd($logged);
                $home = new Home('Home','registerloggedAction');
                $home->registerloggedAction();
                //$home->registerloggedAction();
                //$this->view->setLayout('registerlogged');
                //$this->view->render('home/index');
            }
            else{
                $home = new Home('Home','indexAction');
                //dnd($home);
                $home->indexAction();
                //$home->indexAction();
                //dnd($_SESSION);
                //$this->view->setLayout('default');
                //$this->view->render('home/index');
            }
        }
        public function signupAction(){

        }
        public function guestAction(){

        }
    }