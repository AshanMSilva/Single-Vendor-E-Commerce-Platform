<?php

class Order extends Model{
    private $order_id, $order_date, $customer_id;

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){            
            $this->$key = $val;
        }
    }

    public static function create_order($cart, $cust_id){
        $db = DB::getInstance();
        $date = date("Y-m-d");
        $id = $db->insert('orders', [
            'order_date' => $date,
            'customer_id' => $cust_id
        ]);

        foreach($cart as $product){
            $db->insert('order_details', [
                'order_id' => $id,
                'product_id' => $product['product_id'],
                'variant_id' => $product['variant_id'],
                'quantity' => $product['quantity']
            ]);
        }
        $details = [];
        $details['order_id'] = $id;
        $details['order_date'] = $date;
        $details['customer_id'] = $cust_id;
        $order_obj = new Order($details);
        return $order_obj;
    }

    public function create_payment($method, $amount, $card){
        parent::set_table_name('payments');
        parent::insert([
            'order_id' => $this->order_id,
            'payment_method' => $method,
            'amount' => $amount,
            'card_number' => $card
        ]);
    }

    public function get_order_id(){
        return $this->order_id;
    }
}