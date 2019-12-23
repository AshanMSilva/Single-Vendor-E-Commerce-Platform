<?php 

define('DS', DIRECTORY_SEPARATOR);
//echo DS;
define('ROOT', dirname(__FILE__));
//echo ROOT;
//var_dump($_SERVER);
//echo $_SERVER["PATH_INFO"]; die();

//load configuration and helper functions

require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php');

//autoload classes

function autoload($className){
	if (file_exists(ROOT . DS . 'core' . DS . $className . '.php')){
		require_once(ROOT . DS . 'core' . DS . $className . '.php');
	}
<<<<<<< HEAD
	elseif(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php'){
		require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
	}
	elseif(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php'){
=======
	elseif(file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')){
		require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
	}
	elseif(file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')){
>>>>>>> model-sample
		require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
	}
}

spl_autoload_register('autoload');		//spl = standard php library		

session_start();

$url = isset($_SERVER["PATH_INFO"]) ? explode('/', ltrim($_SERVER["PATH_INFO"], '/')) : [];
//var_dump($url);

//$db = DB::getInstance();

//route the request
Router::route($url);

//require_once(ROOT . DS . 'core' . DS . 'bootstrap.php');