<?php
    class Account extends Controller{
        public function __construct($controller,$action){
            parent::__construct($controller,$action);
        }

        public function logoutAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    session_destroy();
                    Router::redirect('home/index');
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }
        }
        public function indexAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    //get account details using id
                    $this->view->setLayout('normal');
                    $this->view->render('account/index');
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }

        }
        public function wishlistAction(){
            if(Session::exists('logged_in')){
                if(Session::get('logged_in')){
                    //get account details using id
                    $this->view->setLayout('normal');
                    $this->view->render('account/wishlist');
                }
                else{
                    Router::redirect('home/index');
                }
            }
            else{
                Router::redirect('home/index');
            }
        }
    }