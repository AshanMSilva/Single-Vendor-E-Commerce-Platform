<?php

class Variant extends Model{
    private $variant_id, $sku, $weight, $price, $stock;
    private $attributes = [];    //associative array name => value

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){
            $this->$key = $val;
        }        
        $this->set_attributes();
    }

    private function set_attributes(){
        // dnd($this->variant_id);
        $resultsQ = $this->_db->select('attributes', ['attribute_name', 'value'], ['conditions' => 'variant_id = ?', 'bind' => [$this->variant_id]]);
        // dnd($resultsQ);

        if($resultsQ != false){
            foreach($resultsQ as $row){
                //dnd($row->attribute_name);
                $this->attributes[$row->attribute_name] = $row->value;            
            }
        }      
        // dnd($this->attributes);
    }

    public function get_variant_id(){
        return $this->variant_id;
    }

    public function get_sku(){
        return $this->sku;
    }

    public function get_weight(){
        return $this->weight;
    }

    public function get_price(){
        return $this->price;
    }

    public function get_stock(){
        return $this->stock;
    }

    public function get_attributes(){
        return $this->attributes;
    }

}