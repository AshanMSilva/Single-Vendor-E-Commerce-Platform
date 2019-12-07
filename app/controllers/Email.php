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
            if(isset($_POST['submit'])){
                $email=$_POST['email'];
                $script ='$(window).on("load",function(){
                    $("#verficationCodeModal").modal("show");
                });';
                Script::set($script);
                Router::redirect('email/validate');
                //dnd($_SESSION);
            }

        }
        public function verifycodeAction(){
            if(isset($_POST['submit'])){
                $code =$_POST['code'];
            }
        }
    }