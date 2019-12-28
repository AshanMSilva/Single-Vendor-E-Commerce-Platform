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

	public static function processTable($customer_id){
		//if zero display no order else display orders in table
		$orders = [1,3,2,4];
		if (count($orders)==0) {
			echo "   <br> <br><br> 
			<section class='tracking_box_area section_gap'>
				<div class = 'whole-wrap pb-100'>
					<div class = 'container'><h3 class='mb-30'>No previous orders to display</h3></div>
				</div>
			</section>";
		} else {
			self::displayTrackbox();
			echo "    <!--================Order_details Area =================-->
				<div class='whole-wrap pb-100'>
						<div class='container'>
				    			<div class='section-top-border'>
								<h3 class='mb-30'>Previous orders</h3>
								<div class='progress-table-wrap'>
									<div class='progress-table'>
										<div class='table-head'>
											<div class='serial'>Order ID</div>
											<div class='country'>Date</div>
											<div class='visit'>Total Price</div>
											<div class='visit'>Current Location</div>
											<div class='visit'>	</div>
										</div>";
			foreach ($orders as $value) {
				Orders::displayRow($value);
			}
					echo "</div>
						</div>
					</div>
			</div>
		</div>    
		<!--================End Order details Area =================-->";
		}
		
	} 

	public static function displayTrackbox(){
		$action = '<?=PROOT?>tracking/trackorderu';
		echo "    <!--================Tracking Box Area =================-->
    <section class='tracking_box_area section_gap'>
        <div class='container'>
            <div class='tracking_box_inner'>
            	<br>
            	<br>
                <p>To track your order please enter your Order ID in the box below and press the 'Track' button.</p>
                <form class='row tracking_form' action='<?=PROOT?>tracking/trackorderu' method='post' novalidate='novalidate'>
                    <div class='col-md-12 form-group'>
                        <input type='text' class='form-control' id='order' name='order' placeholder='Order ID' onfocus='this.placeholder = ''' onblur='this.placeholder = 'Order ID''>
                    </div>
                    <div class='col-md-12 form-group'>
                        <button type='submit' value='submit' name='submit' class='primary-btn'>Track Order</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
        <!--================End Tracking Box Area =================-->";
	}
}