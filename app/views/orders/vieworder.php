<?php $this->setSiteTitle('Order Progress')?>
	
<?php $this->start('head')?>
<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>


    <!--==============get order id from link================-->
            	<?php $order_id = $data[0];
            	$record  = (isset($data[1][0])) ? $data[1][0] : 0 ;
            	$trackstring = strval($record->tracking_info);
             	// dnd($record);

            	if (isset($_POST['track'])) {
            		$posttrackstring = strval($_POST['track']);

            	} else {
            		$posttrackstring = 'none';
            	}
            	
            	//exit();
            	//dnd($_POST);

            	if (is_int($record)){
            		if ($record==0 and $_SESSION['logged_in']==true) {
	            		 $this->end();
	            		 Alert::set('Either the Tracking ID does not exist or this is a store pickup order. Please enter a valid ID.');
	            		 Router::redirect('orders/uservieworder');
	            	}
	            	elseif ($record==0) {
	            		 $this->end();
	            		 Alert::set('Either the Tracking ID does not exist or this is a store pickup order. Please enter a valid ID.');
	            		 Router::redirect('orders/guestvieworder');
	            	}
	            	
	            }
	            /*else{
	            	if (isset($_POST['track'])and $record->tracking_info=='' ) {
	            		 $this->end();
	            		 Alert::set('The Order ID does not exist for this card number. Please enter a valid Card number.');
	            		 Router::redirect('orders/guestvieworder');
	                }
	                elseif (isset($_POST['track']) and $trackstring!=$posttrackstring) {
	                	$this->end();
	            		 Alert::set('Please enter The correct card number');
	            		 Router::redirect('orders/guestvieworder');
	                }*/
	            	// elseif ($record->customer_id!=$_SESSION['registered_customer']) {
		            // 	$this->end();
	            	// 	 Alert::set('There are no orders under this ID for this account');
	            	// 	 Router::redirect('orders/uservieworder');
	           		// }	
	            //}
				



            	?>
    <!--================Order details Area =================-->

    <section class="order_details section_gap">
        <div class="container">




	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<div class="row order_d_inner">
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Order Info</h4>
						<ul class="list">
							<li><span>Track ID</span> : <?php echo $record->tracking_info ?> </li>
							<li><span>Date</span> : <?php echo $record->order_date; ?></li>
							<li><span>Total</span> : <?php echo $record->amount; ?></li>
							<li><span>Payment method</span> : <?php echo $record->payment_method; ?></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Delivery Info</h4>
						<ul class="list">
							<li><span>Courier ID</span> : <?php echo $record->courier_id; ?></li>
							<li><span>Courier name</span> : <?php $n = $record->first_name.' '.$record->last_name; 
															echo $n; ?></li>
							<li><span>Courier email</span> : <?php echo $record->email; ?></li>
							<li><span>Delivery Method </span> : <?php echo $record->delivery_method; ?></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Shipping Address</h4>
						<ul class="list">
							<li><span>House No</span> : <?php echo $record->house_number; ?></li>
							<li><span>Street</span> : <?php echo $record->street; ?></li>
							<li><span>City</span> : <?php echo $record->city; ?></li>
							<li><span>State</span> : <?php echo $record->state; ?></li>
							<li><span>Postcode </span> : <?php echo $record->zip_code; ?></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row order_d_inner">
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Expected Delivery Date</h4>
						<ul class="list">
							<li><?php echo $record->estimated_date; ?></li><!--make the changes for delivered-->
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Status</h4>
						<ul class="list">
							<li><?php echo $record->status; ?></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Current Location</h4>
						<ul class="list">
							<li><?php echo $record->current_location; ?></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="order_details_table">
				<h2>Order Details</h2>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col">Quantity</th>
								<th scope="col">Total</th>
							</tr>
						</thead>
						<tbody>


							<?php 

							$db=DB::getInstance();
							$products = $db->call_procedure('get_products_of_order',[$order_id]);
							//dnd($products);

							foreach ($products as $obj) {
								$itemname = $obj->title;
								$qty = $obj->quantity;
								$price = $obj->price;


								echo'<tr>
								<td>
									<p>'.$itemname.'</p>
								</td>
								<td>
									<h5>'.$qty.'</h5>
								</td>
								<td>
									<p>$'.$price.'</p>
								</td>
							</tr>';

							}	?>
							<!--
							<tr>
								<td>
									<h4>Subtotal</h4>
								</td>
								<td>
									<h5></h5>
								</td>
								<td>
									<p>$2160.00</p>
								</td>
							</tr>
							<tr>
								<td>
									<h4>Shipping</h4>
								</td>
								<td>
									<h5></h5>
								</td>
								<td>
									<p>Flat rate: $50.00</p>
								</td>
							</tr>
							-->
							<tr>
								<td>
									<h4>Total</h4>
								</td>
								<td>
									<h5></h5>
								</td>
								<td>
									<p><?php echo '$'.$record->amount; ?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
        </div>
    </section>
    <!--================End Tracking Box Area =================-->


<?php $this->end()?>