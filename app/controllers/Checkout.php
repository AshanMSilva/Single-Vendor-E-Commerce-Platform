<?php

class Checkout extends Controller{

    public function __construct($controller,$action){
        parent::__construct($controller,$action);
    }

    public function confirmDetailsAction(){

        if(isset($_POST['confirm_details'])){
            // dnd($_POST);
            $post_array = Input::get_array($_POST, ['confirm_details']);
            $data = [];
            $cart = new Cart();
            $cart_products = $cart->get_products();
            // dnd($cart_products);

            $cart_details = [];
            $prod_count = count($cart_products);
            for($i = 0; $i < $prod_count; $i++){
                $cart_details[$i]['title'] = $cart_products[$i]['product_obj']->get_title();
                $cart_variant = $cart_products[$i]['product_obj']->get_variants()[0];
                $cart_details[$i]['sku'] = $cart_variant->get_sku();
                $cart_details[$i]['price'] = floatval($cart_variant->get_price());
                $cart_details[$i]['quantity'] = intval($cart_products[$i]['quantity']);
            }
            // dnd($cart_details);

            $data['total'] = $cart->get_cart_total();            
            // $post_array = Input::get_array($_POST, ['confirm_details']);
            /*$post_array = ['delivery_method' => 'deliver', 
            'house_number' => 21, 'street' => 'Reed Avenue', 'city' => 'New Orleans', 
            'state' => 'Nevada', 'zip_code' => '45781', 'contact' => '112-1356-298'
            ];*/
            // dnd($post_array);

            if(Session::exists('registered_customer')){

                $cust_id = Session::get('registered_customer');
                $reg_cust_obj = RegisteredCustomer::get_reg_cust_by_id($cust_id);
                $reg_cust = [];
                $reg_cust['first_name'] = $reg_cust_obj->get_first_name();
                $reg_cust['last_name'] = $reg_cust_obj->get_last_name();
                $reg_cust['cards'] = $reg_cust_obj->get_cards();
                // dnd($cards);
                $data['reg_cust'] = $reg_cust;
            }

            else{
                $guest_cust = [];
                $guest_cust['first_name'] = $post_array['firstName'];
                $guest_cust['last_name'] = $post_array['lastName'];            
                $data['guest_cust'] = $guest_cust;
            }
            
            if(isset($post_array['houseNumber'])){
                $address = [
                    'house_number' => $post_array['houseNumber'],
                    'street' => $post_array['street'],
                    'city' => $post_array['city'],
                    'state' => $post_array['state'],
                    'zip_code' => $post_array['zipCode']
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

            /*if($post_array['payment_method'] == 'card'){         // radio input type
                $data['card'] = $post_array['card_num'];                    
            }
            else{
                $data['card'] = null;
            }*/

            if($post_array['contactNumber'] != ''){
                // dnd($post_array['contactNumber']);
                $data['contact'] = $post_array['contactNumber'];
            }
            elseif($post_array['contact_list'] != 'no_select'){
                $data['contact'] = $post_array['contact_list'];
            }
            
            $data['cart'] = $cart_details;

            Session::set('order_data', $data);            
            // dnd($_SESSION);           
            // render checkout/confirmCheckout
            $this->view->setLayout('normal');
            $this->view->render('mycart/checkout', $data);
        }        
    }

    /* create guest customer record
    create order record
    add products to order_details    
    create payment record
    create delivery record
    clear cart
    update variant stock */

    public function confirmCheckoutAction(){

        if(isset($_POST['confirm_checkout']) && Session::exists('order_data')){
            dnd($_POST);
            $post_array = Input::get_array($_POST, ['confirm_checkout']);
            $order_data = Session::get('order_data');
            // dnd($post_array);         
            $cart_obj = new Cart();

            if(Session::exists('registered_customer')){
                $cust_id = Session::get('registered_customer');                
                $my_cart = $cart_obj->get_reg_cust_cart($cust_id);
                $reg_cust_obj = RegisteredCustomer::get_reg_cust_by_id($cust_id);
            }
            else{
                //insert guest customer
                $cust_id = GuestCustomer::create_guest_cust($order_data['guest_cust']);
                $my_cart = Session::get('my_cart');
            }
            // Product::update_stock($my_cart);
            
            // dnd($my_cart);
            $order_obj = Order::create_order($my_cart, $cust_id);
            // dnd($order_obj);
            // $order_data['cart'] = $my_cart;

            if($post_array['method'] == 'card'){
                $payment_method = "card";
                $order_data['payment_method'] = 'Card Payment';
                if($post_array['card_number'] != ''){
                    $card = $post_array['card_number'];
                    if(Session::exists('registered_customer')){
                        $reg_cust_obj->add_new_card($card);
                    }
                }
                elseif($post_array['card_list'] != 'no_select') {
                    $card = $post_array['card_list'];
                }                
            }
            else{
                $payment_method = "cash";
                $order_data['payment_method'] = 'Cash on Delivery';
                $card = null;
            }
            $order_data['card'] = $card;

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
            $order_data['order_date'] = date("Y/m/d");

            $cart_obj->clear_cart();

            Product::update_stock($my_cart);
            Session::delete('order_data');
            
            //render the view mycart/confirmation
            //pass the order_details to the view
            $this->view->setLayout('normal');
            $this->view->render('mycart/confirmation', $order_data);
        }        
    }
}