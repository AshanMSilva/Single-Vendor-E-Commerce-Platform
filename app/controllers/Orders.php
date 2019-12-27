<?php

class Orders extends Controller{

	public function __construct($controller,$action){
		parent::__construct($controller,$action);
		$this->view->setLayout('default');
	}

	public function vieworderAction(){
		$this->view->render('orders/vieworder');
	}

	public function guestvieworderAction(){
		$this->view->render('orders/guestvieworder');
	}

	public function uservieworderAction(){
		$this->view->render('orders/uservieworder');
	}

	public static function displayRow($order_id){
		$date='2019-12-31';
		$totalprice='Rs.1000.00';
		$currentlocation = 'hambanthota';
		$link='#';
		echo "<div class='table-row'>
				  <div class='serial'>";
				echo $order_id;
			echo "</div>";
			echo "<div class='country'>";
				echo $date;
			echo "</div>";
			echo "<div class='visit'>";
				echo $totalprice;
			echo "</div>";
			
			echo "<div class='visit'>";
				echo $currentlocation;
			echo "</div>";

			echo "<div class='visit'>";
				echo "<div class='container border-top-generic' align='middle' >
												<div class='button-group-area mt-40'>
													<a href='".$link."' class='genric-btn info circle'>view</a>
												</div>
												</div>";
			echo "</div>";

		echo "</div>";
						
	}

	public static function processTable(){
		//if zero display no order else display orders in table
	} 
}