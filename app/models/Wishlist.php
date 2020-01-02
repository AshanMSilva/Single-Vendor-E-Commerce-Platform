<?php

class Wishlist extends Model{    
    private $customer_id, $products;    // products array consists of sub arrays [product_obj, quantity]

    public function __construct(){
        parent::__construct();
    }

    public function insert($details){
        parent::set_table_name('wishlists');
        parent::insert([
            'customer_id' => $this->customer_id,
            'product_id' => $details['product_id'],
            
        ]);
    }

    public function update($fields, $params){
        parent::set_table_name('wishlists');
        // dnd($params);
        parent::update($fields, $params);
    }

    public function add_product($details){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            parent::set_table_name('wishlists');

            $result_query = $this->_db->select('wishlists', '*', [
                'conditions' => ['customer_id = ?', 'product_id = ?'], 
                'bind' => [$this->customer_id, $details['product_id']]
            ]);
            // dnd($result_query);

            if($result_query == false){
                $this->insert($details);
            }
            
            else{
               
            }      
            
        }

        
    }

    public function get_reg_cust_wishlist($cust_id){
        $this->customer_id = $cust_id;
        $my_wishlist = [];

        $resultsQ = $this->_db->select('wishlists','*', [
            'conditions' => 'customer_id = ?', 
            'bind' => [$this->customer_id]
        ]);
        if($resultsQ != false){
            foreach($resultsQ as $result){
                $product = [];
                $product['product_id'] = $result->product_id;
                $my_wishlist[] = $product;
            }
        }
        return $my_wishlist;
    }

    public function get_products(){

        if(Session::exists('registered_customer')){
            $this->customer_id = Session::get('registered_customer');
            $resultsQ = $this->_db->select('wishlists','*', [
                'conditions' => 'customer_id = ?', 
                'bind' => [$this->customer_id]
            ]);
            // dnd($resultsQ);
            // $resultsQ = parent::call_procedure('select_customer_cart', $cust_id);
            
            if($resultsQ != false){
                foreach($resultsQ as $result){
                    $product = Product::get_product_by_id($result->product_id);
                    $this->products[] = ['product_obj' => $product,];
                }
                // dnd($this->products);
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
                'conditions' => ['customer_id = ?', 'product_id = ?'],
                'bind' => [$this->customer_id, $id]
            ]);
        }

        
    }

}