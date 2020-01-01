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
    public static function get_category_with_most_orders(){
        $db=DB::getInstance();
        $categories=array();
        $numAll=$db->select('order_details','sum(quantity) as cc')[0]->cc;
        $resultQ=$db->call_procedure('get_category_with_most_orders');
        foreach($resultQ as $result){
            $title=$result->title;
            
            $count=$result->cc;
            $categories[$title]=$count;
        }
        return [$categories,$numAll];

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
    
    public static function get_categories_from_key($key){
        $categories=array();
        $db=DB::getInstance();
        $results=$db->select('categories','category_id',[
            'conditions'=> ['title like ?'],
            'bind'=>[$key]
            ]);
        $rowcount=$db->get_row_count();
        for($i=0;$i<$rowcount;$i++){
            $category_id=$results[$i]->category_id;
            array_push($categories,$category_id);
        }
        return $categories;
        
    }
    
    public  static function get_products_in_category($category_id,$arr=[]){
        
        // //database connection
        $con=DB::getInstance(); 
        $sqlstmt="SELECT value  FROM attributes WHERE attribute_name= ?";
        $res=$con->query($sqlstmt,["colour"]);
        $c=$res->get_row_count();
        for($i=0;$i<$c;$i++){
            $f=$res->results()[$i]->value;
        }
        //check for sub categories    
        $sqlSubCat="SELECT sub_category_id  FROM category_relations WHERE category_id= ? ";
        $resultSubCat=$con->query($sqlSubCat,[$category_id]);
        $len=$resultSubCat->get_row_count();                                   
        if ($len=="0"){ // no sub category - simple category  
            // just display the products of this category
            $sqlProducts="SELECT product_id  FROM  product_category_relations join products using (product_id) WHERE category_id= ? ";
            $resultProducts=$con->query($sqlProducts,[$category_id]);
            $rowcount=$resultProducts->get_row_count();
            for($i=0;$i<$rowcount;$i++){
                $product_id=$resultProducts->results()[$i]->product_id;
                if(in_array($product_id,$arr)==false){
                    array_push($arr,$product_id);                 
                }               
            }return $arr;        
        }
        else{ // if this category is a complex category
            for($i=0;$i<$len;$i++){
                $sub_category_id=$resultSubCat->results()[$i]->sub_category_id; 
                return array_merge($arr,Category::get_products_in_category($sub_category_id,$arr)); // recursion 
            }
        }
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