<?php


class Report extends Controller{

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }
    public function indexAction(){
        $this->view->setLayout('normal');
        $this->view->render('report/index');
    }
    public function most_reach_periodAction(){
        $product_id=$_GET['id'];
        $date_count=Product::get_reach_period($product_id);
        $this->view->setLayout('normal');
        $this->view->render('report/reach_period',$date_count);
    }
    public function category_ordersAction(){
        $result=Category::get_category_with_most_orders();
        $this->view->setLayout('normal');
        $this->view->render('report/category_orders',$result);
    }
    public function most_sales_productsAction(){
        $date1=$_GET["from"];
        $date2=$_GET["to"];
        if($date1>=$date2){
            Alert::set("Given Period is Not Valid!!");
            Alert::displayscriptalert();     
            $this->view->setLayout('normal');
            $this->view->render('report/index');       
        }
        else{
        $result=Product::get_mostsales_products($date1,$date2);
        $products=$result[0];
        $numAll=$result[1];
        $period=[$date1,$date2];
        $data=[$products,$numAll,$period];
        
        $this->view->setLayout('normal');
        $this->view->render('report/most_sales_products',$data);
        }

    }

}



?>