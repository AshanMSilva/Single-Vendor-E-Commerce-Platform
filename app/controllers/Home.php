<?php
    class Home extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        public function indexAction(){
            //dnd(Product::top_selling_products());
            
            //$topProducts = Product::top_selling_products();
            
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    $this->view->setLayout('registerlogged');
                    $this->view->render('home/index');
                    //$this->view->render('home/index',$topProducts);
                }
                else{
                    $this->view->setLayout('default');
                    $this->view->render('home/index');
                    //$this->view->render('home/index',$topProducts);
                }
            }
            else{
                $this->view->setLayout('default');
                $this->view->render('home/index'); 
                //$this->view->render('home/index',$topProducts);
            }
            
            
        }
        public function registerloggedAction(){
            // dnd($_SESSION);
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    $this->view->setLayout('registerlogged');
                    $this->view->render('home/index');
                    //$this->view->render('home/index',$topProducts);
                }
                else{
                    $this->view->setLayout('default');
                    $this->view->render('home/index');
                    //$this->view->render('home/index',$topProducts);
                }
            }
            else{
                $this->view->setLayout('default');
                $this->view->render('home/index'); 
                //$this->view->render('home/index',$topProducts);
            }
        }
        




    }



        
        //public function guestloggedAction(){
        //    $this->view->setLayout('guestlogged');
        //    $this->view->render('home/index');
        //}
    
    