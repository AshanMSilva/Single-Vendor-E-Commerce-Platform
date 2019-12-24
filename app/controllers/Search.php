<?php
    class Search extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }

        public function searchResultAction(){
            $con=DB::getInstance();

            if(isset($_POST["key"])){
                $x= Input::get('key');
            }
            //call function
            $lastView=$this->searchItem($x,$con);
            $prodDetails=array();
            foreach($lastView as $product_id){
                $prodDetails[$product_id]=$this->getDetailsOfProduct($product_id,$con);
            }
            Session::set('x',$x);
            Session::set('prodDetails',$prodDetails);

            $this->view->setLayout('default');
            $this->view->render('search/searchResult');
        }
        
        //this function returns the all products in the given category
        //this function is called in searchResultAction
        public function viewProductsInCategory($category_id,$con,$arr){ 

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
                    return array_merge($arr,$this->viewProductsInCategory($sub_category_id,$con,$arr)); // recursion 
                }
            }
        } 
        //this function returns all matching products for the given key
        //this function is called in searchResultAction
        public function searchItem($key,$con){
            $lastView=array();
            //if key is a category name
            $x="%".$key."%";
            $sqlCat="SELECT category_id FROM categories WHERE title like ? ";
            $resultCat=$con->query($sqlCat,[$x]);

            //view products in categories
            $rowcount=$resultCat->get_row_count();
            for($i=0;$i<$rowcount;$i++){
                $category_id=$resultCat->results()[$i]->category_id;
                $lastView=array_merge($lastView,$this->viewProductsInCategory($category_id,$con,$lastView));               
            }                                                             
            // if key is a product name
            $sql="SELECT product_id  FROM products WHERE title like ? ";
            $result=$con->query($sql,[$x]);

            //view products
            $rowcount=$result->get_row_count();
            for($i=0;$i<$rowcount;$i++){
                $product_id=$result->results()[$i]->product_id;
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
        public function getDetailsOfProduct($product_id,$con){
            
            // sql query to get the title
            $sqlTitleResult="SELECT title FROM products WHERE product_id= ? ";
            $titleResult=$con->query($sqlTitleResult,[$product_id]);

            $title=$titleResult->results()[0]->title;
            //query to get the price range
            $sqlPrices="SELECT MIN(price) as minPrice,MAX(price) as maxPrice  from variants where product_id= ? ";
            $PriceResult=$con->query($sqlPrices,[$product_id]);
            $minPrice=$PriceResult->results()[0]->minPrice;
            $maxPrice=$PriceResult->results()[0]->maxPrice;
            return array($title,$minPrice,$maxPrice);
        }
}
