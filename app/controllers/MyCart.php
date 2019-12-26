<?php

class MyCart extends Controller{

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function indexAction(){
        $cart = new Cart();
        $total = $cart->get_cart_total();     
        $products = $cart->get_products();      // return array looks like: [ [product_obj, quantity], .... ]
        $data = [$products, $total];
        //render the view of cart. pass the data array
    }

    public function removeFromCartAction($variant_id){
        $cart = new Cart();
        $cart->remove_product($variant_id);
    }

    public function updateCartAction(){
        // POST array looks like: ['variant1' => '13', 'quantity1' => 2, 'variant2' => '5', 'quantity2' => 3 ...]
        if(isset($_POST['update'])){
            $post_array = Input::get_array($_POST, ['update', 'checkout']);
            $length = count($post_array)/2;
            $cart = new Cart();

            for($i=1; $i <= $length; $i++){
                $variant_id = $post_array['variant' . $i];
                $quantity = $post_array['quantity' . $i];
                $cart->update_product($variant_id, $quantity);
            }
        }
    }
}