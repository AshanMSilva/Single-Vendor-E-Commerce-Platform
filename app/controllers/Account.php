<?php
    class Account extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }

        public function logoutAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    session_destroy();
                    Router::redirect('home/index');
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }
        }
        public function indexAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    $id = Session::get('registered_customer');
                    //get account details using id
                    
                    $this->view->setLayout('normal');
                    $reg_cust = RegisteredCustomer::get_reg_cust_by_id($id);
                    //get details
                    $data['accountDetails'] = [$reg_cust];
                    $this->view->render('account/index',$data);
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }

        }
        public function wishlistAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    $id = Session::get('registered_customer');
                    //dnd($id);
                    //get account details using id
                    //$data['wishlist'] = [$id];
                    $this->view->setLayout('normal');
                    $this->view->render('account/wishlist',$data);
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }
        }
        public function addtowishlistAction($productId){
            if(isset($productId)){

                if(Session::exists('logged_in')){
                    if(Session::get('logged_in')){
                        $regid = Session::get('registered_customer');
                        //back end for save data in databse in wishlist table
                        Alert::set('Product is added to yor wishlist');
                        $this->wishlistAction();
                    }
                    else{
                        Alert::set('You should log first..');
                        Router::redirect('home/index');
                    }
                }
                else{
                    Alert::set('You should log first..');
                    Router::redirect('home/index');
                }
            }
        }
        public function displayordersAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    $id = Session::get('registered_customer');
                    //dnd($id);
                    //get customers previous orders using id
                    //$data['wishlist'] = [$id];
                    $this->view->setLayout('normal');
                    $this->view->render('account/orders',$data);
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }
        }
    }