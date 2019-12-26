<?php

class Checkout extends Controller{

    public function __construct($controller,$action){
        parent::__construct($controller,$action);
    }

    public function confirmDetailsAction(){
        if(isset($_POST['checkout'])){

            if(Session::exists('registered_customer')){
                $cust_id = Session::get('registered_customer');
                $reg_cust_obj = RegisteredCustomer::get_reg_cust_by_id($cust_id);
                // pass object to view - set default values using object. customer can change delivery address, card 
            }
            else{
                // render view - guest customer should fill the form in the view. first name, last name should be taken
            }
        }
    }

    public function confirmCheckoutAction(){

        if(/*isset($_POST['confirm_details'])*/ true){

            $data = [];
            $cart = new Cart();
            $cart_products = $cart->get_products();
            // dnd($cart_products);
            $data['total'] = $cart->get_cart_total();            
            // $post_array = Input::get_array($_POST, 'confirm_details');
            $post_array = ['delivery_method' => 'deliver', 
            'house_number' => 21, 'street' => 'Reed Avenue', 'city' => 'New Orleans', 
            'state' => 'Nevada', 'zip_code' => '45781',
            'payment_method' => 'card', 'card_num' => '232-451-038-204', 'contact' => '112-1356-298'
            ];
            // dnd($post_array);

            if(Session::exists('registered_customer')){

                $cust_id = Session::get('registered_customer');
                $reg_cust_obj = RegisteredCustomer::get_reg_cust_by_id($cust_id);
                $reg_cust = [];
                $reg_cust['first_name'] = $reg_cust_obj->get_first_name();
                $reg_cust['last_name'] = $reg_cust_obj->get_last_name();
            }

            else{
                $guest_cust = [];
                $guest_cust['first_name'] = $post_array['first_name'];
                $guest_cust['last_name'] = $post_array['last_name'];            
                $data['guest_cust'] = $guest_cust;
            }
            
            if($post_array['delivery_method'] == 'deliver'){
                $address = [
                    'house_number' => $post_array['house_number'],
                    'street' => $post_array['street'],
                    'city' => $post_array['city'],
                    'state' => $post_array['state'],
                    'zip_code' => $post_array['zip_code']
                ];
                $data['delivery_address'] = $address;
                // dnd($data);
                $estimated_date = System::calc_delivery_estimate($cart_products, $post_array['city']);
                $data['estimated_date'] = $estimated_date;
            }
            else{
                $available_date = System::calc_delivery_estimate($cart_products);
                $data['available_date'] = $available_date;
            }

            if($post_array['payment_method'] == 'card'){         // radio input type
                $data['card'] = $post_array['card_num'];                    
            }
            else{
                $data['card'] = null;
            }
            $data['contact'] = $post_array['contact'];
            Session::set('order_data', $data);

            $data['cart'] = $cart_products; 
            dnd($_SESSION);           
            // render checkout/confirmCheckout
        }        
    }

    /* create guest customer record
    create order record
    add products to order_details    
    create payment record
    create delivery record
    clear cart
    update variant stock */

    public function createOrderAction(){

        if(isset($_POST['confirm_checkout']) && Session::exists('order_data')){
            $order_data = Session::get('order_data');            
            $cart_obj = new Cart();

            if(Session::exists('registered_customer')){
                $cust_id = Session::get('registered_customer');                
                $my_cart = $cart_obj->get_reg_cust_cart($cust_id);
            }
            else{
                //insert guest customer
                $cust_id = GuestCustomer::create_guest_cust($order_data['guest_cust']);
                $my_cart = Session::get('my_cart');
            }
            $order_obj = Order::create_order($my_cart, $cust_id);
            $order_data['cart'] = $my_cart;

            if($order_data['card'] == null){
                $payment_method = "cash";
                $card = null;
            }
            else{
                $payment_method = "card";
                $card = $order_data['card'];
            }
            $amount = $order_data['total'];
            $order_obj->create_payment($payment_method, $amount, $card);

            $details = [];
            $details['order_id'] = $order_obj->get_order_id();
            if(array_key_exists('estimated_date', $order_data)){
                $details['estimated_date'] = $order_data['estimated_date'];
            }
            else{
                $details['available_date'] = $order_data['available_date'];
            }
            $details['customer_contact'] = $order_data['contact'];
            $address = $order_data['delivery_address'];

            $tracking_id = Delivery::create_delivery($details, $address);
            $order_data['tracking_id'] = $tracking_id;

            $cart_obj->clear_cart();

            Product::update_stock($my_cart);
        }        
    }
}