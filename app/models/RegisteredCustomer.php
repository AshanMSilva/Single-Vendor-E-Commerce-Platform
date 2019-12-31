<?php

class RegisteredCustomer extends Customer{
    private $email, $house_number, $street, $city, $state, $zip_code;
    private $contacts, $cards;
    
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

    public static function get_reg_cust_by_id($id){
        $db = DB::getInstance();
        $resultsQ = $db->call_procedure('get_reg_customer_by_id', $id);
        //dnd($resultsQ);
        $reg_cust = new RegisteredCustomer($resultsQ[0]);

        $contactsQ = $db->select('customer_contacts', 'contact_number', [
            'conditions' => 'customer_id = ?',
            'bind' => [$reg_cust->get_id()]
        ]);
        if($contactsQ != false){
            foreach($contactsQ as $contact){
                $this->contacts[] = $contact->contact_number;
            }
        }

        $cardsQ = $db->select('card_details', 'card_number', [
            'conditions' => 'customer_id = ?',
            'bind' => [$reg_cust->get_id()]
        ]);
        if($cardsQ != false){
            foreach($cardsQ as $card){
                $this->cards[] = $card->card_number;
            }
        }
        
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

        parent::set_table_name('customer_contacts');
        parent::insert([
            'customer_id' => $id,
            'contact_number' => $details['contact1']
        ]);
        if(array_key_exists('contact2', $details)){
            parent::insert([
                'customer_id' => $id,
                'contact_number' => $details['contact2']
            ]);
        }
    }

    public function get_id(){
        // dnd($this->customer_id);
        return $this->customer_id;
    }

    public function get_first_name(){
        return $this->first_name;
    }

    public function get_last_name(){
        return $this->last_name;
    }
    
    public function set_address($details){
        $address_keys = ['house_number', 'street', 'city', 'state', 'zip_code'];
        foreach($details as $key => $val){
            if(in_array($key, $address_keys)){
                $this->$key = $val;
            }
        }
    }

    public function get_house_number(){
        return $this->house_number;
    }

    public function get_street(){
        return $this->street;
    }

    public function get_city(){
        return $this->city;
    }

    public function get_zipcode(){
        return $this->zip_code;
    }
    public function get_state(){
        return $this->state;
    }
    public function get_contacts(){
        return $this->contacts;
    }
    public function get_cards(){
        return $this->cards;
    }
}