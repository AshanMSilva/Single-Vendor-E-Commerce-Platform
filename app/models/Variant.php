<?php

class Variant extends Model{
    private $variant_id, $sku, $weight, $price, $stock;
    private $attributes;    //associative array name => value

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
        foreach($resultsQ as $row){
            //dnd($row->attribute_name);
            $this->attributes[$row->attribute_name] = $row->value;            
        }
        // dnd($this->attributes);
    }

    public function get_attributes(){
        return $this->attributes;
    }

}