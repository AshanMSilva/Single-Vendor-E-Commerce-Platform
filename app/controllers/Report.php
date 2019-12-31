<?php


class Report extends Controller{

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
    }
    public function indexAction(){
        $this->view->setLayout('normal');
        $this->view->render('report/index');
    }

    public function category_ordersAction(){
        $result=Category::get_category_with_most_orders();
        $this->view->setLayout('normal');
        $this->view->render('report/category_orders',$result);
    }
    public function most_sales_productsAction(){
        $date1=$_GET["from"];
        $date2=$_GET["to"];
        $products=Product::get_mostsales_products($date1,$date2);
        $period=[$date1,$date2];
        $data=[$products,$period];
        
        $this->view->setLayout('normal');
        $this->view->render('report/mostsales_products',$data);

    }

}



?>