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

    public static function get_product_by_id($id){
        $db = DB::getInstance();
        $resultsQ = $db->select('products', '*', ['conditions' => 'product_id = ?', 'bind' => [$id]]);
        // dnd($resultsQ);
        $product = new Product($resultsQ[0]);
        // dnd($product);
        return $product;
    }

    public function set_variant($id){
        parent::set_model_name('Variant');
        parent::set_table_name('variants');
        $variant = parent::select(['variant_id', 'sku', 'weight', 'price', 'stock'], [
            'conditions' => 'variant_id = ?',
            'bind' => [$id]
        ]);
        // dnd($variant);
        $this->variants = $variant;
    }

    public function select_variants(){
        parent::set_model_name('Variant');
        parent::set_table_name('variants');
        $this->variants = parent::select(['variant_id', 'sku', 'weight', 'price', 'stock'], [
            'conditions' => 'product_id = ?',
            'bind' => [$this->product_id]
        ]);   
    }

    public static function update_stock($cart_array){
        $db = DB::getInstance();
        foreach($cart_array as $product){
            $new_stock = 'stock - ' . $product['quantity'];
            $db->update('variants', ['stock' => $new_stock], [
                'conditions' => 'variant_id = ?',
                'bind' => [$product['variant_id']]
            ]);
        }
    }

    public function get_belonging_categories(){
        $resultsQ = parent::call_procedure('get_belonging_categories', $this->product_id);
        $category_array = [];

        if($resultsQ != false){
            $count = count($resultsQ);
            for($i = 0; $i < $count; $i++){
                $category_array[$i]['category_id'] = $resultsQ[$i]->category_id;
                $category_array[$i]['title'] = $resultsQ[$i]->title;
            }
            return $category_array;
        }
        else{
            return [];
        }
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