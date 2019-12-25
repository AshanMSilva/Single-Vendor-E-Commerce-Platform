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
            $con=DB::getInstance();
            $attributes=$this->getAttributes($product_id,$con);
            Session::set('attributes',$attributes);

            //get the category
            $sql="SElECT title FROM categories join product_category_relations using (category_id) where product_id = ?";
            $category_name=$con->query($sql,[$product_id])->results()[0]->title;
            Session::set('category_name',$category_name);

            //get the brand
            $brand_name=$con->query("SELECT brand from products where product_id= ?",[$product_id])->results()[0]->brand;
            Session::set('brand_name',$brand_name);
            $this->view->setLayout('normal');
            $this->view->render('product/productDisplay');
        }

        //this function returns the all attributes for given product
        function getAttributes($product_id,$con){
            $attributes=array();
            $sql="select attribute_name,value from attributes  where product_id= ?"; 
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
                    if(in_array($value,$attributes[$attribute_name])==false){
                        array_push($attributes[$attribute_name],$value);
                    }
                }
            }
            return $attributes;            
        }

        public function productAddAction(){



        }
    
    }