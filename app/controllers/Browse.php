<?php

class Browse extends Controller{

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }

    public function loadCategoriesAction($id){
        if(isset($id)){
            /*$roots = Category::get_root_categories();
            dnd($roots);*/

            $category_model = new model();
            $category_model->set_model_name('Category');
            $category_model->set_table_name('categories');
            $results = $category_model->select('*', ['conditions' => 'category_id = ?', 'bind' => [$id]]);
            // dnd($results);
            $root_category = $results[0];
            //dnd($root_category);
            
            if($root_category->has_sub_category()){
                $categories = $root_category->get_sub_categories();
                dnd($categories);
            }
            else{
                //load products belong to the category
                //echo "else"; die();
                $products = $root_category->get_category_products();
                dnd($products[0]);
            }           
        }
    }

    public function viewProductAction($id){
        if(isset($id)){
            $product_model = new model();
            $product_model->set_model_name('Product');
            $product_model->set_table_name('products');
            $results = $product_model->select('*', ['conditions' => 'product_id = ?', 'bind' => [$id]]);
            $product = $results[0];
            $product->select_variants();
            dnd($product->get_variants());          // [0]->get_attributes()
        }
        
    }
}