<?php

class View{
	protected $_head, $_body, $_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;
<<<<<<< HEAD

=======
	protected $_data = [];	//an array of data needed at the view
>>>>>>> model-sample
	public function __construct(){
	
	}

<<<<<<< HEAD
	public function render($viewName){
=======
	public function render($viewName, $data = []){
>>>>>>> model-sample
		$viewArr = explode('/', $viewName);
		$viewString = implode(DS, $viewArr);

		if(file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')){
			include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
<<<<<<< HEAD
			include (ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
=======
			include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
			$this->_data = $data;
>>>>>>> model-sample
		}
		else{
			die('The view - ' . $viewName . ' does not exist.');
		}
	}
	public function render_without_layout($viewName){
		$viewArr = explode('/', $viewName);
		$viewString = implode(DS, $viewArr);

		if(file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')){
			include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
			//include (ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
		}
		else{
			die('The view - ' . $viewName . ' does not exist.');
		}
	}

	public function content($type){
		if($type == 'head'){
			return $this->_head;
		}
		elseif($type == 'body'){
			return $this->_body;
		}
		return false;
	}

	public function start($type){
		$this-> _outputBuffer = $type;
		ob_start();
	}

	public function end(){
		if($this->_outputBuffer == 'head'){
			$this->_head = ob_get_clean();
		}
		elseif($this->_outputBuffer == 'body'){
			$this->_body = ob_get_clean();
		}
		else{
			die('You must first run the start method.');
		}
	}

	public function siteTitle(){
		return $this->_siteTitle;
	}

	public function setSiteTitle($title){
		$this->_siteTitle = $title;
	}

	public function setLayout($path){
		$this->_layout = $path;
	}

<<<<<<< HEAD
=======
	public function get_data(){
		return $this->_data;
	}

>>>>>>> model-sample
}