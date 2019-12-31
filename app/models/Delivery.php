<?php

class Delivery extends Model{
    private $order_id, $courier_id, $delivery_method, $tracking_info, $estimated_date, $completed_date;
    private $status, $customer_contact, $house_number, $street, $city, $state, $zip_code;

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){
            $this->$key = $val;
        }
    }
    
    public static function create_delivery($details, $address = null){
        $db = DB::getInstance();
        $tracking_id = uniqid() . "_" . rand(100000, 999999); 
        if(array_key_exists('estimated_date', $details)){
            $db->insert('deliveries', [
                'order_id' => $details['order_id'],
                'delivery_method' => 'delivery',
                'tracking_info' => $tracking_id,
                'estimated_date' => $details['estimated_date'],
                'customer_contact' => $details['customer_contact'],
                'house_number' => $address['house_number'],
                'street' => $address['street'],
                'city' => $address['city'],
                'state' => $address['state'],
                'zip_code' => $address['zip_code']
            ]);
        }

        else{
            $db->insert('deliveries', [
                'order_id' => $details['order_id'],
                'delivery_method' => 'store_pickup',
                'tracking_info' => $tracking_id,
                'estimated_date' => $details['available_date'],
                'customer_contact' => $details['customer_contact']
            ]);
        }
        return $tracking_id;        
    }
}