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

	public static function displayRow($orderrecord){
		$order_id = $orderrecord->order_id;
		$date = $orderrecord->order_date ;
		$totalprice = $orderrecord->amount;
		$currentlocation = $orderrecord->tracking_info;
		$status = $orderrecord->status ;
		$ViewLink = PROOT.'orders/vieworder/'.$order_id;
		$deleteLink = '#';
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
				echo $status;
			echo "</div>";
			
			echo "<div class='visit'>";
				echo "<div class='container border-top-generic' align='middle' >
												<div class='button-group-area mt-40'>
													<a href='".$ViewLink."' class='genric-btn primary circle'>View</a>
												</div>
												</div>";
			echo "</div>";

			echo "<div class='visit'>";
				echo "<div class='container border-top-generic' align='middle' >
												<div class='button-group-area mt-40'>
													<a href='".$deleteLink."' class='genric-btn danger circle'>Delete</a>
												</div>
												</div>";
			echo "</div>";

		echo "</div>";
						
	}

	public static function processOrdersTable($user_id){
		//if zero display no order else display orders in table

		$db=DB::getInstance();
		$result = $db->call_procedure('get_undeleted_orders',[$user_id]);

		if (count($result)==0) {
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
											<div class='visit'>Status</div>
											<div class='visit'></div>
											<div class='visit'>	</div>
										</div>";
			foreach ($result as $orderrecord) {
				self::displayRow($orderrecord);
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
		$action = PROOT.'orders/vieworder';
		echo "    <!--================Tracking Box Area =================-->
    <section class='tracking_box_area section_gap'>
        <div class='container'>
            <div class='tracking_box_inner'>
            	<br>
            	<br>
                <p>To track your order please enter your Order ID in the box below and press the 'Track' button.</p>
                <form class='row tracking_form' action='".$action."' method='post' novalidate='novalidate'>
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