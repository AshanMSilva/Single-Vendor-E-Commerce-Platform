<?php

class Cart extends Model{    
    private $customer_id, $products;    // products array consists of sub arrays [product_obj, quantity]

    public function __construct(){
        parent::__construct();
    }

    public function insert($details){
        parent::set_table_name('carts');
        parent::insert([
            'customer_id' => $this->customer_id,
            'product_id' => $details['product_id'],
            'variant_id' => $details['variant_id'],
            'quantity' => $details['quantity']
        ]);
    }

    public function update($fields, $params){
        parent::set_table_name('carts');
        // dnd($params);
        parent::update($fields, $params);
    }

    public function add_product($details){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            parent::set_table_name('carts');

            $result_query = $this->_db->select('carts', '*', [
                'conditions' => ['customer_id = ?', 'variant_id = ?'], 
                'bind' => [$this->customer_id, $details['variant_id']]
            ]);
            // dnd($result_query);

            if($result_query == false){
                $this->insert($details);
            }
            elseif($result_query[0]->removed_flag == '1'){
                $this->update(['quantity' => $details['quantity'], 'removed_flag' => '0'],
                [
                    'conditions' => ['customer_id = ?', 'variant_id = ?'], 
                    'bind' => [$this->customer_id, $details['variant_id']]
                ]);
            }
            else{
                $new_quantity = intval($result_query[0]->quantity) + $details['quantity'];
                // dnd(intval($new_quantity);
                $this->update(['quantity' => $new_quantity], [
                    'conditions' => ['customer_id = ?', 'variant_id = ?'], 
                    'bind' => [$this->customer_id, $details['variant_id']]
                ]);
            }      
            
        }

        else{
            if(Session::exists('my_cart')){
                $cart_products = Session::get('my_cart');
                // dnd($cart_products);
                $count = count($cart_products);
                // dnd($count);
                $index = -1;
                for($i = 0; $i < $count; $i++){
                    // echo $i;
                    if($cart_products[$i]['variant_id'] == $details['variant_id']){
                        // dnd($cart_products[$i]['variant_id']);
                        $index = $i;
                        break;
                    }
                }
                // dnd($index);
                if($index != -1){
                    // dnd($cart_products[$index]);
                    $current_quantity = $cart_products[$index]['quantity'];
                    $new_quantity = $current_quantity + $details['quantity'];
                    // dnd($new_quantity);
                    Session::update_array('my_cart', $index, 'quantity', $new_quantity);
                }
                else{
                    Session::add_to_array('my_cart', $details);
                }
            }
            else{
                Session::add_to_array('my_cart', $details);
            }
            
            // my_cart looks like: [['product_id' => 2, 'variant_id' => 13, 'quantity' => 1], ...]
        }
    }

    public function get_reg_cust_cart($cust_id){
        $this->customer_id = $cust_id;
        $my_cart = [];

        $resultsQ = $this->_db->select('optimized_carts','*', [
            'conditions' => 'customer_id = ?', 
            'bind' => [$this->customer_id]
        ]);
        if($resultsQ != false){
            foreach($resultsQ as $result){
                $product = [];
                $product['product_id'] = $result->product_id;
                $product['variant_id'] = $result->variant_id;
                $product['quantity'] = $result->quantity;
                $my_cart[] = $product;
            }
        }
        return $my_cart;
    }

    public function get_products(){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            $resultsQ = $this->_db->select('optimized_carts','*', [
                'conditions' => 'customer_id = ?', 
                'bind' => [$this->customer_id]
            ]);
            // dnd($resultsQ);
            // $resultsQ = parent::call_procedure('select_customer_cart', $cust_id);
            
            if($resultsQ != false){
                foreach($resultsQ as $result){
                    $product = Product::get_product_by_id($result->product_id);
                    $product->set_variant($result->variant_id);
                    $this->products[] = ['product_obj' => $product, 'quantity' => $result->quantity];
                }
                // dnd($this->products);
                return $this->products;
            }
            else{
                return [];
            }           

        }
        else{
            if(Session::exists('my_cart')){
                $cart_products = Session::get('my_cart');
                foreach($cart_products as $product){
                    $product_obj = Product::get_product_by_id($product['product_id']);
                    $product_obj->set_variant($product['variant_id']);
                    $this->products[] = ['product_obj' => $product_obj, 'quantity' => $product['quantity']];
                }                
                return $this->products;
            }
            else{
                return [];
            }
        }
    }

    public function remove_product($id){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            $this->update(['removed_flag' => '1'], [
                'conditions' => ['customer_id = ?', 'variant_id = ?'],
                'bind' => [$this->customer_id, $id]
            ]);
        }

        else{
            if(Session::exists('my_cart')){
                $cart_products = Session::get('my_cart');
                // dnd($cart_products);
                $count = count($cart_products);
                // dnd($count);
                $index = -1;
                for($i = 0; $i < $count; $i++){
                    if($cart_products[$i]['variant_id'] == $id){
                        $index = $i;
                        break;
                    }
                }
                // dnd($index);
                if($index != -1){
                    // dnd($index);
                    Session::remove_from_array('my_cart', $index);
                }                
            }
        }
    }

    public function update_product($variant_id, $quantity){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            $this->update(['quantity' => $quantity], [
                'conditions' => ['customer_id = ?', 'variant_id = ?'], 
                'bind' => [$this->customer_id, $variant_id]
            ]);
        }

        else{
            if(Session::exists('my_cart')){
                $cart_products = Session::get('my_cart');
                // dnd($cart_products);
                $count = count($cart_products);
                // dnd($count);
                $index = null;
                for($i = 0; $i < $count; $i++){
                    if($cart_products[$i]['variant_id'] == $variant_id){
                        // dnd($cart_products[$i]['variant_id']);
                        $index = $i;
                        break;
                    }
                }
                // dnd($index);
                if($index != null){
                    // dnd($cart_products[$index]);
                    Session::update_array('my_cart', $index, 'quantity', $quantity);
                }
            }
        }
    }

    public function get_cart_total(){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            $resultsQ = parent::call_function('calc_total_price', $this->customer_id);
            $total = $resultsQ[0]->calc_total_price;
            // dnd($total);
            return $total;
        }
        else{
            if(Session::exists('my_cart')){
                $cart_products = Session::get('my_cart');
                $total = 0;

                foreach($cart_products as $product){
                    $variant_id = $product['variant_id'];
                    $result_query = $this->_db->select('variants', 'price', [
                        'conditions' => 'variant_id = ?', 
                        'bind' => [$variant_id]
                    ]);
                    $price = floatval($result_query[0]->price);
                    $total += $price * $product['quantity'];
                }
                return $total;
            }
            else{
                return 0;
            }
        }        
    }

    public function clear_cart(){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            $this->update(['removed_flag' => '1'], [
                'conditions' => ['customer_id = ?', 'removed_flag = ?'],
                'bind' => [$this->customer_id, '0']
            ]);
        }

        else{
            Session::delete('my_cart');
        }
    }
}