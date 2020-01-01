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
						<li><a href="#"><span>Tracking ID</span> : <?=$data['tracking_id']?></a></li>
						<li><a href="#"><span>Date</span> : <?=$data['order_date']?></a></li>
						<li><a href="#"><span>Total</span> : <?=$data['total']?></a></li>
						<li><a href="#"><span>Payment method</span> : <?=$data['payment_method']?></a></li>
						<?php if($data['payment_method'] == "Card Payment"): ?>
							<li><a href="#"><span>Card Number</span> : <?=$data['card']?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="details_item">
					<?php if(isset($data['delivery_address'])): ?>							
						<h4>Delivery Address</h4>
						<ul class="list">
							<li><a href="#"><span>House Number</span> : <?=$data['delivery_address']['house_number']?></a></li>
							<li><a href="#"><span>Street</span> : <?=$data['delivery_address']['street']?></a></li>
							<li><a href="#"><span>City</span> : <?=$data['delivery_address']['city']?></a></li>
							<li><a href="#"><span>State </span> : <?=$data['delivery_address']['state']?></a></li>
							<li><a href="#"><span>Postal Code </span> : <?=$data['delivery_address']['zip_code']?></a></li>
							<li><a href="#"><span>Estimated Delivery Date </span> : <?=$data['estimated_date']?></a></li>
						</ul>
					<?php else: ?>
						<h4>Warehouse Address</h4>
						<ul class="list">
							<li><a href="#"><span>House Number</span> : C Stores</a></li>
							<li><a href="#"><span>Street</span> : Main Road</a></li>
							<li><a href="#"><span>City</span> : Cleveland</a></li>
							<li><a href="#"><span>State </span> : Texas</a></li>
							<li><a href="#"><span>Postal Code </span> : 37722</a></li>
							<li><a href="#"><span>Estimated Availability Date </span> : <?=$data['available_date']?></a></li>
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
								<h4>Total Price</h4>
							</td>
							<td>
								<h5></h5>
							</td>
							<td>
								<h5></h5>
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