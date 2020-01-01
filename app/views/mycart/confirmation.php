<?php $this->setSiteTitle('Confirmation')?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
<?php //Alert::displayscriptalert();
	$data = $this->get_data();
	$cart = $data['cart'];
    $prod_count = count($cart);
?>


<!--================Order Details Area =================-->
<section class="order_details section_gap">
	<div class="container">
		<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
		<div class="row order_d_inner">
			<div class="col-lg-6">
				<div class="details_item">
					<h4>Order Info</h4>
					<ul class="list">
						<li><strong><span>Tracking ID</span> : <?=$data['tracking_id']?></strong></li>
						<li><span>Date</span> : <?=$data['order_date']?></li>
						<li><span>Total</span> : $<?=$data['total']?></li>
						<li><span>Payment method</span> : <?=$data['payment_method']?></li>
						<?php if($data['payment_method'] == "Card Payment"): ?>
							<li><span>Card Number</span> : <?=$data['card']?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="details_item">
					<?php if(isset($data['delivery_address'])): ?>							
						<h4>Delivery Address</h4>
						<ul class="list">
							<li><span>House Number</span> : <?=$data['delivery_address']['house_number']?></li>
							<li><span>Street</span> : <?=$data['delivery_address']['street']?></li>
							<li><span>City</span> : <?=$data['delivery_address']['city']?></li>
							<li><span>State </span> : <?=$data['delivery_address']['state']?></li>
							<li><span>Postal Code </span> : <?=$data['delivery_address']['zip_code']?></li>
							<li><span>Estimated Delivery Date </span> : <?=$data['estimated_date']?></li>
						</ul>
					<?php else: ?>
						<h4>Warehouse Address</h4>
						<ul class="list">
							<li><span>House Number</span> : C Stores></li>
							<li><span>Street</span> : Main Road</li>
							<li><span>City</span> : Cleveland</li>
							<li><span>State </span> : Texas</li>
							<li><span>Postal Code </span> : 37722</li>
							<li><span>Estimated Availability Date </span> : <?=$data['available_date']?></li>
						</ul>
					<?php endif; ?>
				</div>
			</div>
			<!--<div class="col-lg-4">
				<div class="details_item">
					<h4>Shipping Address</h4>
					<ul class="list">
						<li><a href="#"><span>Street</span> : 56/8</a></li>
						<li><a href="#"><span>City</span> : Los Angeles</a></li>
						<li><a href="#"><span>Country</span> : United States</a></li>
						<li><a href="#"><span>Postcode </span> : 36952</a></li>
					</ul>
				</div>
			</div>
		</div>-->
		<div class="order_details_table col-sm-12">
			<h2>Order Details</h2>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">Product</th>
							<th scope="col">SKU</th>
							<th scope="col">Price</th>
							<th scope="col">Quantity</th>
							<th scope="col">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php for($i = 0; $i < $prod_count; $i++): ?>
							<tr>
								<td>
									<p><?=$cart[$i]['title']?></p>
								</td>
								<td>
									<p><?=$cart[$i]['sku']?></p>
								</td>								
								<td>
									<p>$<?=$cart[$i]['price']?></p>
								</td>
								<td>
									<h5><?=$cart[$i]['quantity']?></h5>
								</td>
								<td>
									<?php
										$sub_total = $cart[$i]['price'] * $cart[$i]['quantity'];
										$sub_total = number_format($sub_total, 2, '.', ',')
									?>
									<p>$<?=$sub_total?></p>
								</td>
							</tr>
						<?php endfor; ?>                                            
						<tr>
							<td>
								<h5></h5>
							</td>
							<td>
								<h5></h5>
							</td>
							<td>
								<h5></h5>
							</td>
							<td>
								<h4>Total Price</h4>
							</td>
							<td>
								<?php $total = number_format($data['total'], 2, '.', ','); ?>
								<h5>$<?=$total?></h5>
							</td>
						</tr>  							
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<!--================End Order Details Area =================-->
    
<?php $this->end()?>