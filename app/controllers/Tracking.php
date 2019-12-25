<?php
    class Tracking extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }

        public function indexAction(){
            $this->view->setLayout('normal');
            $this->view->render('tracking/index');
        }
        public function trackorderAction(){
            if(isset($_POST['submit'])){
                $orderId =$_POST['order'];
                $email =$_POST['email'];
                //search order id and email in the database
                /*if(condition =true){
                    //get order trcking details from database
                    //display order details
                    $this->view->setLayout('normal');
                    $this->view->render('tracking/trackorderdetails');
                }
                else{
                    Alert::set('Your entered tracking Id is incorrect.');
                    Router::redirect('tracking/index');
                }*/
            }
        }

    }