<?php

class Router {

	public static function route($url){
		//dnd($url);		// helper function defned in app/lib/helpers/helpers.php
		
		//controller
		$controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
		$controller_name = $controller;
		array_shift($url);
		
		//dnd($url);
		//dnd($controller);

		$action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action' : 'indexAction';
		$action_name = $controller;
		array_shift($url);
		//echo $controller . '<br>';
		//echo $action . '<br>';
		//echo $action_name;
		//dnd($url);

		//parameters
		$queryParams = $url;	//not handled parameters with spaces 

		$dispatch = new $controller($controller_name, $action);
		//dnd($dispatch);

		if (method_exists($controller, $action)){
			call_user_func_array([$dispatch, $action], $queryParams);	// $dispatch->registerAction($queryParams);
		}
		else{
			die("That method does not exist in the controller - " . $controller_name);
		}
	}
	public static function redirect($location){
		if(!headers_sent()){
			header('Location: '.PROOT.$location);
			exit();
		}
		else{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.PROOT.$location.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$location.'"/>';
			echo '</noscript>';
			exit;
		}
	}
}