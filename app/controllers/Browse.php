<?php

class Browse extends Controller{
    private $category_array = [];

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $root_objs = Category::get_root_categories();
        $this->category_array = System::get_all_categories($root_objs, []);
    }

    /*public function indexAction(){
        $root_objs = Category::get_root_categories();
        $result = System::get_all_categories($root_objs, []);
        dnd($result);
    }*/

    public function loadCategoriesAction($id){

        if(isset($id)){
            /*$roots = Category::get_root_categories();
            dnd($roots);*/

            $category_model = new model();
            $category_model->set_model_name('Category');
            $category_model->set_table_name('categories');
            $results = $category_model->select('*', ['conditions' => 'category_id = ?', 'bind' => [$id]]);
            // dnd($results);
            if ($results != false){
                
                $root_category = $results[0];
                $root_title = $root_category->get_title();
                $data = [];
                $data['category_title'] = $root_title;
                $data['category_array'] = $this->category_array;
                $this->view->setSiteTitle("C Stores - " . $root_title);
                //dnd($root_category);
                
                if($root_category->has_sub_category()){
                    $categories = $root_category->get_sub_categories();     // render the view categories/index. pass category objs
                    // dnd($categories);
                    $data['sub_categories'] = $categories;              
                    
                    $this->view->setLayout('normal');
                    $this->view->render('categories/index', $data);
                }
                else{
                    //load products belong to the category
                    //echo "else"; die();
                    $products = $root_category->get_category_products();    // render the view category-products/index. pass product objs
                    // dnd($products[0]);
                    $data['category_products'] = $products;
                    $this->view->setLayout('normal');
                    $this->view->render('category-products/index', $data);
                }        
            }

            else{
                echo("There's no category for the given id");
            }            
        }
    }

    public function viewProductAction($id){

        if(isset($id)){
            $product_model = new model();
            $product_model->set_model_name('Product');
            $product_model->set_table_name('products');
            $results = $product_model->select('*', ['conditions' => 'product_id = ?', 'bind' => [$id]]);
            
            if($results != false){
                $product = $results[0];
                $product->select_variants();
                // dnd($product->get_variants());          // [0]->get_attributes()                

                $belonging_cat = $product->get_belonging_categories();
                // dnd($belonging_cat);

                $table_headers = [];
                array_push($table_headers, 'SKU', 'Weight', 'Price', 'Stock');
                $attributes_array = $product->get_variants()[0]->get_attributes();
                foreach($attributes_array as $key => $val){
                    $table_headers[] = $key;
                }                
                // dnd($table_headers);

                $variant_objs = $product->get_variants();
                $count = count($variant_objs);
                $variants = [];
                
                for($i = 0; $i < $count; $i++){
                    $attributes = $variant_objs[$i]->get_attributes();

                    $variants[$i][] = $variant_objs[$i]->get_variant_id();
                    $variants[$i][] = $variant_objs[$i]->get_sku();
                    $variants[$i][] = $variant_objs[$i]->get_weight() . 'g';
                    $variants[$i][] = '$' . $variant_objs[$i]->get_price();
                    $variants[$i][] = $variant_objs[$i]->get_stock();

                    foreach($attributes as $key => $value){
                        $variants[$i][] = $value;
                    }
                    
                }
                // dnd($variants);
                $data['belonging_categories'] = $belonging_cat;
                $data['variants'] = $variants;
                $data['table_headers'] = $table_headers;
                $data['product'] = $product;
                
                $this->view->setLayout('normal');
                $this->view->render('single-product/index', $data);
                // render the view single-product/index. pass product obj
            }

            else{
                echo("There's no product for the given id");
            }           
        }        
    }

    public function addToCartAction(){
        // product_id, variant_id, quantity should be sent through post from the single-product view
        //$post_array = Input::get_array($_POST, ['add']);     // contains product_id, variant_id, quantity
        // dnd(Session::get('registered_customer'));

        if(isset($_POST['addToCart'])){
            // dnd($_POST);
            $post_array = Input::get_array($_POST, ['addToCart']);
            $post_array['quantity'] = intval($post_array['quantity']);
            // $post_array = ['product_id' => '2', 'variant_id' => '13', 'quantity' => 2];
            // dnd($post_array['product_id']);
            // dnd($post_array);
            $cart = new Cart();
            // $cart = Cart::get_instance();
            $cart->add_product($post_array);
            Alert::set('Product added to your cart');
            // dnd($_SESSION);
            // Router::redirect('browse/viewProduct/' . $post_array['product_id']);
            Router::goback();
        }
    }
}