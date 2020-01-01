<?php
    class Singleproduct extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        public function productDisplayAction(){
            $product_id=$_GET["id"];
            $title=$_GET["title"];
            Session::set('title',$title);
            Session::set('product_id',$product_id);
            
            $attributes=Product::get_attributes($product_id);
            Session::set('attributes',$attributes);
            
            $details=Product::get_details_of_product($product_id);
            $category_name=$details["category"];
            $brand=$details["brand"];
            Session::set('category_name',$category_name);
            Session::set('brand_name',$brand);
            $this->view->setLayout('normal');
            $this->view->render('singleproduct/productDisplay');
        }
        public function productAddAction(){
        }
    
    }