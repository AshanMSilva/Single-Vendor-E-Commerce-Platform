<?php
    class Cart extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        public function indexAction(){
            $this->view->setLayout('normal');
            $this->view->render('cart/index');

        }
        public function checkoutAction(){
            $this->view->setLayout('normal');
            $this->view->render('cart/checkout');
        }
        public function confirmationAction(){
            $this->view->setLayout('normal');
            $this->view->render('cart/confirmation');
        }
    }