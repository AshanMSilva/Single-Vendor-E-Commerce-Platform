<?php
    //load configuration and helper functions
    require_once(ROOT.DS.'config'.DS.'config.php');
    require_once(ROOT.DS.'app'.DS.'lib'.DS.'helpers'.DS.'functions.php');

    //autoload classes
    function __autoload($lassName){
        if(file_exists(ROOT.DS.'core'.DS.$classname.'.php')){
            require_once(ROOT.DS.'core'.DS.$classname.'.php');
        }
        elseif(file_exists(ROOT.DS.'app'.DS.'controllers'.DS.$classname.'.php')){
            require_once(ROOT.DS.'app'.DS.'controllers'.DS.$classname.'.php');

        }
        elseif(file_exists(ROOT.DS.'app'.DS.'models'.DS.$classname.'.php')){
            require_once(ROOT.DS.'app'.DS.'models'.DS.$classname.'.php');

        }

    }

    //route the request

    Router::router($url);