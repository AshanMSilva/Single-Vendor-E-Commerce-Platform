<?php
    class Forgotpassword extends Controller{

        public function __construct($controller, $action){
            parent::__construct($controller, $action);
        }

        public function indexAction(){
            if(isset($_POST['submit'])){
                $email = $_POST['email'];
                 

                if(System::email_exists($email)){
                    $subject= 'Forgot Password request';
                    $randcode= System::generaterandcode();
                    Session::set('randcode', $randcode);
                    $message ="ForgotPassword Code: " . $randcode . " . Please use the given code to verify your email. Please reset Your Password.";
                    if(System::sendmail($email, $subject, $message)){
                        Alert::set('ForgotPassword code is sent to your email address successfully');
                        $this->view->setLayout('normal');
                        $this->view->render('forgotpassword/index',$email);
                    }
                    else{
                        $script ='$(window).on("load",function(){
                            $("#forgotPasswordModal").modal("show");
                        });';
                        Script::set($script);
                        Alert::set('An error occured while sending the email. Try re-sending the ForgotPassword Code. Check whether the email address is correct. Check your internet connection.');
                        Router::redirect('home/index');
                    }
                    
                }
                else{
                    $script ='$(window).on("load",function(){
                        $("#forgotPasswordModal").modal("show");
                    });';
                    Script::set($script);
                    Alert::set('Your entered email address is incorrect. Check whether the email address is correct.');
                    Router::redirect('home/index');
                }

                
            }
            
        }
        public function verifycodeAction(){
            if(isset($_POST['submit'])){
                $code = $_POST['code'];
                $email =$_POST['email'];
                if(Session::exists('randcode')){
                    $randcode = Session::get('randcode');
                    if($code==$randcode){
                        $script ='$(window).on("load",function(){
                            $("#resetpasswordModal").modal("show");
                        });';
                        Script::set($script);
                        //Session::delete('randcode');
                        $this->view->setLayout('normal');
                        $this->view->render('forgotpassword/index',$email);
                    }
                    else{
                        Alert::set('Your input code is incorrect. Please enter the correct code or click send button to send verification code again..!');
                        $this->view->setLayout('normal');
                        $this->view->render('forgotpassword/index',$email);
                    }
                }
                else{
                    Alert::set('Re enter your code');
                    $this->view->setLayout('normal');
                    $this->view->render('forgotpassword/index',$email);
                }

            }

        }
        public function resetpasswordAction(){
            //back end for change password
            if(isset($_POST['submitnewpassword'])){
                $password = $_POST['password'];
                $re_password = $_POST['re-password'];
                $email=$_POST['email'];
                if(System::validate_password($password)){

                    if($password == $re_password){
                        $re_password= null;
                        Session::delete('password');
                        Session::delete('re-password');
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        Alert::set('Password reset successfully. Please use your new password to login..!');
                        //back end code for change password                     
                        Router::redirect('home/index');
                    }
                    else{
                        $script ='$(window).on("load",function(){
                            $("#resetpasswordModal").modal("show");
                        });';
                        Alert::set('Password and Re-Password fields are not the same');
                        Script::set($script);
                        $this->view->setLayout('normal');
                        $this->view->render('forgotpassword/index',$email);
                    }                      
                }
                else{
                    $script ='$(window).on("load",function(){
                        $("#resetpasswordModal").modal("show");
                    });';
                    Alert::set('Password does not have the required security level');
                    Script::set($script);
                    $this->view->setLayout('normal');
                    $this->view->render('forgotpassword/index',$email);
                }                   
            }
            else{
                dnd($_POST);
            }
        }
    }
