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
            if(isset($_POST['sendFeedback'])){
                $name= $_POST['name'];
                $senderEmail =$_POST['email'];
                $subject =$_POST['subject'];
                $message =$_POST['message'];
                $receiverEmail= "ashansilva.17@cse.mrt.ac.lk"; //send feedback to our email address
                $message=$message."\n Sender's Email Address: ".$senderEmail;
                if(System::sendmail($receiverEmail, $subject, $message)){
                    Alert::set('Your feedback sent successfully..!');
                    Router::redirect('contact/index');
                }
                else{
                    Alert::set('An error occured while sending the feedback. Check whether the email address is correct. Check your internet connection.');
                    Router::redirect('contact/index');
                }
            }
            else{
                Router::redirect('contact/index');
            }
        }

    }