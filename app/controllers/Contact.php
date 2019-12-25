<?php
    class Contact extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }
        public function indexAction(){
            $this->view->setLayout('normal');
            $this->view->render('contact/index');
        }
        public function contactprocessAction(){
            //implement to send feedback
        }

    }