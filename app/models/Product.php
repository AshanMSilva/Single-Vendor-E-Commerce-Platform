<?php

class Product extends Model{
    private $product_id, $title, $brand, $image, $min_price, $max_price;
    private $variants;   

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){
            $this->$key = $val;            
        }
    }

    public static function top_selling_products(){
        $products = [];
        $db = DB::getInstance();
        $resultsQ = $db->call_procedure('top_selling_products');
        foreach($resultsQ as $result){
            $products[] = new Product($result);
        }
        return $products;
    }

    public function select_variants(){
        parent::set_model_name('Variant');
        parent::set_table_name('variants');
        $this->variants = parent::select(['variant_id', 'sku', 'weight', 'price', 'stock'], [
                                            'conditions' => 'product_id = ?',
                                            'bind' => [$this->product_id]
                                        ]);     
    }

    public function get_product_id(){
        return $this->product_id;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_brand(){
        return $this->brand;
    }

    public function get_image(){
        return $this->image;
    }

    public function get_min_price(){
        return $this->min_price;
    }

    public function get_max_price(){
        return $this->max_price;
    }

    public function get_variants(){
        return $this->variants;
    }
}