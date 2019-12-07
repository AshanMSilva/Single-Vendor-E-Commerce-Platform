<?php
    class Email extends controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);

        }
        public function validateAction(){
            $this->view->setLayout('normal');
            $this->view->render('email/validate');
        }
        public function sendAction(){

        }
    }