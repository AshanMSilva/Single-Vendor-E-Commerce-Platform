<?php

if(isset($_POST['submit'])){
    Session::set('logged',true);
    $email = $_POST['email'];
    
}
else{
    dnd($_POST);
}
