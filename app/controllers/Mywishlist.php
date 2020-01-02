<?php

class Mywishlist extends Controller{

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction(){
        
        if(Session::exists('logged_in')){
            if(Session::get('logged_in')){
                $wishlist = new Wishlist();
             
                $products = $wishlist->get_products();      // return array looks like: [ [product_obj, quantity], .... ]
                $id = Session::get('registered_customer');
                $regcust = RegisteredCustomer::get_reg_cust_by_id($id);
                $data = [$products,$regcust];
            }
            else{
                $data = [];
            }
        }
        else{
            $data = [];
        }
        
        
        
        //render the view of cart. pass the data array
        $this->view->setLayout('normal');
        $this->view->render('mywishlist/index',$data);
    }

    public function removeFromCartAction($product_id){
        // dnd($variant_id);
        $cart = new Cart();
        $cart->remove_product($product);
        Router::redirect('Mywishlist/index');
    }

    
}