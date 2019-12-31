<?php

class MyCart extends Controller{

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction(){
        $cart = new Cart();
        $total = $cart->get_cart_total();     
        $products = $cart->get_products();      // return array looks like: [ [product_obj, quantity], .... ]
        if(Session::exists('logged_in')){
            if(Session::get('logged_in')){
                $id = Session::get('registered_customer');
                $regcust = RegisteredCustomer::get_reg_cust_by_id($id);
                $data = [$products, $total,$regcust];
            }
            else{
                $data = [$products, $total];
            }
        }
        else{
            $data = [$products, $total];
        }
        
        
        
        //render the view of cart. pass the data array
        $this->view->setLayout('normal');
        $this->view->render('mycart/index',$data);
    }

    public function removeFromCartAction($variant_id){
        $cart = new Cart();
        $cart->remove_product($variant_id);
        Router::redirect('MyCart/index');
    }

    public function updateCartAction(){
        // dnd($_POST);
        // POST array looks like: ['variant1' => '13', 'quantity1' => 2, 'variant2' => '5', 'quantity2' => 3 ...]
        if(isset($_POST['update'])){
            $post_array = Input::get_array($_POST, ['update']);
            // dnd($post_array);
            $count = intval($post_array['count']);            
            $cart = new Cart();

            for($i=0; $i < $count; $i++){
                $variant_id = $post_array['variant' . $i];
                $quantity = $post_array['qty' . $i];
                // dnd($quantity);
                $cart->update_product($variant_id, $quantity);
            }
            Router::redirect('MyCart/index');
        }
    }
}