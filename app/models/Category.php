<?php

class Category extends Model{
    private $category_id, $title, $description, $image;
    private $sub_categories;    //array of sub_category ids

    public function __construct($details){
        parent::__construct();
        foreach($details as $key => $val){
            $this->$key = $val;
        }
    }

    public static function get_root_categories(){
        $root_categories = [];
        $db = DB::getInstance();
        $resultsQ = $db->call_procedure('select_root_categories');
        foreach($resultsQ as $result){
            $category = new Category($result);
            $root_categories[] = $category;
        }
        return $root_categories;
    }
    
    public function get_sub_categories(){
        $sub_categories = [];
        //dnd($this->category_id);
        //$db = DB::getInstance();
        $resultsQ = parent::call_procedure('select_sub_categories', $this->category_id);
        //dnd($resultsQ);
        foreach($resultsQ as $result){
            //dnd($result);
            $category = new Category($result);
            // dnd($category);
            $sub_categories[] = $category;
        }
        return $sub_categories;
    }    

    public function has_sub_category(){
        //dnd($this->category_id);
        parent::set_table_name('category_relations');
        $count = parent::select_count('sub_category_id', ['conditions' => 'category_id = ?', 'bind' => [$this->category_id]]);
        return $count;
    }

    public function get_category_products(){
        $products = [];

        $resultsQ = parent::call_procedure('select_category_products', $this->category_id);
        foreach($resultsQ as $result){
            $products[] = new Product($result);
        }
        return $products;
    }

    public function get_category_id(){
        return $this->category_id;
    }

    public function get_title(){
        return $this->title;
    }

    public function get_description(){
        return $this->description;
    }

    public function get_image(){
        return $this->image;
    }

    public function set_table_name($name){
        parent::set_table_name($name);
    }
}