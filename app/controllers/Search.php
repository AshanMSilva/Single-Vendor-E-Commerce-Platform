<?php
    class Search extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        public function searchResultAction(){
            if(isset($_GET["key"])){
                $x= Input::get('key');
            }
            Session::set('xx',$x);
            $x=Session::get('xx');
            //call function
            $lastView=$this->searchItem($x);

            //algo improvement
            if(count($lastView)==0){
                $keys=explode(" ",$x);
                foreach($keys as $keyword){
                    $temp_ids=$this->searchItem($keyword);
                    foreach($temp_ids as $pid){
                        if(in_array($pid,$lastView)==false){
                            array_push($lastView,$pid);
                        }
                    }
                }
            }

            $prodDetails=array();
            foreach($lastView as $product_id){
                $prodDetails[$product_id]=$this->getDetailsOfProduct($product_id);
            }
            $data=[$prodDetails,$x];
            $this->view->setLayout('normal');
            $this->view->render('search/searchResult',$data);
        }
        
        //this function returns the all products in the given category
        //this function is called in searchResultAction
        public function viewProductsInCategory($category_id,$arr){ 
            return Category::get_products_in_category($category_id);
        } 
        //this function returns all matching products for the given key
        //this function is called in searchResultAction
        public function searchItem($key){
            $lastView=array();
            $x="%".$key."%";
            $categories=Category::get_categories_from_key($x);
            foreach($categories as $category_id){
                $lastView=array_merge($lastView,$this->viewProductsInCategory($category_id,$lastView));               
            }                                                             
            
            // if key is a product name 
            // view products
            $products=Product::get_products_from_key($x);
            foreach($products as $product_id){
                if(in_array($product_id,$lastView)==false){
                    array_push($lastView,$product_id);
                } 
            }
            //get distinct product_ids
            $distinct=array();
            foreach($lastView as $product_id){
                if(in_array($product_id,$distinct)==false){
                    array_push($distinct,$product_id);
                }
            }
            return $distinct;
        }
        public function getDetailsOfProduct($product_id){
            return Product::get_details_of_product($product_id);
        }
}