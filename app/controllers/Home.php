<?php
    class Home extends Controller{

        public function __construct($controller, $action){
            parent::__construct($controller, $action);
        }

        public function indexAction(){

            $root_categories = Category::get_root_categories();
            // dnd($root_categories);
            $data['categories'] = $root_categories;

            if(Session::exists('registered_customer')){
                $this->view->setLayout('registerlogged');
                $this->view->render('home/index', $data);
            }
            else{
                $this->view->setLayout('default');
                $this->view->render('home/index', $data);
            }            
        }


        /*public function registerloggedAction(){
            // dnd($_SESSION);
            
        }*/
        //public function guestloggedAction(){
        //    $this->view->setLayout('guestlogged');
        //    $this->view->render('home/index');
        //}

        // following index method should be used instead of above two methods

        /*public function indexAction(){
            if(Session::exists('registered_customer')){
                $this->view->setLayout('registerlogged');
            }
            else{
                $this->view->setLayout('default');
            }            
            $this->view->render('home/index');
        }*/    
    }
    