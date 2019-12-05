<?php
    class Home extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        public function indexAction(){
            $this->view->setLayout('default');
            $this->view->render('home/index');
        }
        public function registerloggedAction(){
            $this->view->setLayout('registerlogged');
            $this->view->render('home/registerlogged');
        }
        public function guestloggedAction(){
            $this->view->setLayout('guestlogged');
            $this->view->render('home/guestlogged');
        }
    }
    