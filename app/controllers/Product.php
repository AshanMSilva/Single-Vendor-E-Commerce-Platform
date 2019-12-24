<?php
    class Product extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }

        public function productDisplayAction(){
            $product_id=$_GET["id"];
            $title=$_GET["title"];
            Session::set('title',$title);
            Session::set('product_id',$product_id);
            $con=DB::getInstance();
            $attributes=$this->getAttributes($product_id,$con);
            Session::set('attributes',$attributes);
            $this->view->setLayout('default');
            $this->view->render('product/productDisplay');
        }

        //this function returns the all attributes for given product
        function getAttributes($product_id,$con){
            $attributes=array();
            $sql="select attribute_name,value from variants join attributes using (variant_id) where product_id= ? "; 
            $result = $con->query($sql,[$product_id]);


            $rowcount=$result->get_row_count();
            for($i=0;$i<$rowcount;$i++){
                $attribute_name=$result->results()[$i]->attribute_name;
                $value=$result->results()[$i]->value;
                
                if(array_key_exists($attribute_name, $attributes)==false){
                    $attributes[$attribute_name]=array();
                    array_push($attributes[$attribute_name],$value);
                }
                else{
                    array_push($attributes[$attribute_name],$value);
                }
            }
            return $attributes;
        }
    
    }