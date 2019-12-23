<?php

class RegisteredCustomer extends Customer{
    private $email, $house_number, $street, $city, $state, $zip_code;
    private $contacts;
    
    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){
            if($key != 'password'){
                $this->$key = $val;
            }
        }
    }

    public static function create_reg_cust($email){
        $db = DB::getInstance();
        $resultsQ = $db->call_procedure('get_customer_details', $email);
        //dnd($resultsQ);
        $reg_cust = new RegisteredCustomer($resultsQ[0]);
        //dnd($resultsQ);
        /*foreach($resultsQ[0] as $key => $val){
            $reg_cust->$key = $val;
        }*/
        //dnd($reg_cust);
        return $reg_cust;   
    }

    public function insert_customer($details){
        parent::set_table_name('customers');
        $id = parent::insert(['first_name' => $details['first_name'],
                       'last_name' => $details['last_name']]);
        
        // dnd($id);        
        $id = intval($id);
        $this->customer_id = $id;
        // $password = password_hash($details['password'], PASSWORD_DEFAULT);
        //dnd($password);
        parent::set_table_name('registered_customers');
        $x = parent::insert([
            'customer_id' => $id,
            'email' => $details['email'],
            'password' => $details['password'],
            'house_number' => $details['house_number'],
            'street' => $details['street'],
            'city' => $details['city'],
            'state' => $details['state'],
            'zip_code' => $details['zip_code']
        ]);
        //dnd($x);
    }

    public function get_id(){
        // dnd($this->customer_id);
        return $this->customer_id;
    }    
}