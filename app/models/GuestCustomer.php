<?php

class GuestCustomer extends Customer{

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){            
            $this->$key = $val;
        }
    }

    public static function create_guest_cust($details){
        $db = DB::getInstance();
        $cust_id = $db->insert('customers', [
            'first_name' => $details['first_name'], 
            'last_name' => $details['last_name']
        ]);
        $db->insert('guest_customers', [
            'customer_id' => $cust_id
        ]);
        return $cust_id;
    }
}