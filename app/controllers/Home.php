<?php
    class Home extends Controller{

        public function __construct($controller, $action){
            parent::__construct($controller, $action);
        }

        public function indexAction(){
            //dnd(Product::top_selling_products());
            // $reg = RegisteredCustomer::get_reg_cust_by_id(16);
            // dnd($reg);
            $root_categories = Category::get_root_categories();
             //dnd($root_categories);
            $data['categories'] = $root_categories;
            $topProducts = Product::top_selling_products();
            $data['topProducts'] =$topProducts;
            
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    //$this->view->setLayout('registerlogged');
                    //$this->view->render('home/index');
                    Router::redirect('home/registerlogged');
                    //$this->view->render('home/index',$topProducts);
                }
                else{
                    $this->view->setLayout('default');
                    $this->view->render('home/index',$data);
                    //$this->view->render('home/index',$topProducts);
                }
            }
            else{
                $this->view->setLayout('default');
                $this->view->render('home/index',$data); 
                //$this->view->render('home/index',$topProducts);
            }
            
            

            /*$root_categories = Category::get_root_categories();
            // dnd($root_categories);
            $data['categories'] = $root_categories;

            if(Session::exists('registered_customer')){
                $this->view->setLayout('registerlogged');
                $this->view->render('home/index', $data);
            }
            else{
                $this->view->setLayout('default');
                $this->view->render('home/index', $data);
            }   */         
        }


        public function registerloggedAction(){
            $root_categories = Category::get_root_categories();
            // dnd($root_categories);
            $data['categories'] = $root_categories;
            $topProducts = Product::top_selling_products();
            $data['topProducts'] =$topProducts;
            // dnd($_SESSION);
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    $this->view->setLayout('registerlogged');
                    $this->view->render('home/index',$data);
                    //$this->view->render('home/index',$topProducts);
                }
                else{
                    //$this->view->setLayout('default');
                    //$this->view->render('home/index');
                    Router::redirect('home/index');
                    //$this->view->render('home/index',$topProducts);
                }
            }
            else{
                //$this->view->setLayout('default');
                //$this->view->render('home/index'); 
                Router::redirect('home/index');
                //$this->view->render('home/index',$topProducts);
            }
        }
        




    }



        
            
        //}
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
    //}
    