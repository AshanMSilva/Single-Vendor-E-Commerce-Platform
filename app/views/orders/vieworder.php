<?php $this->setSiteTitle('Order Progress')?>
	
<?php $this->start('head')?>
<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>


    <!--==============get order id from link================-->
    <?php $link = $_SERVER['REQUEST_URI'] ;
    $a = explode('/', $link);
    $order_id=(int)($a[4]);
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
							<li><span>Order ID</span> : <?php echo $order_id ?> </li>
							<li><span>Date</span> : Los Angeles</li>
							<li><span>Total</span> : USD 2210</li>
							<li><span>Payment method</span> : Check payments</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Delivery Info</h4>
						<ul class="list">
							<li><span>Courier ID</span> : 56/8</li>
							<li><span>Courier name</span> : Los Angeles</li>
							<li><span>Courier email</span> : United States</li>
							<li><span>Delivery Method </span> : 36952</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Shipping Address</h4>
						<ul class="list">
							<li><span>House No</span> : 56/8</li>
							<li><span>Street</span> : Los Angeles</li>
							<li><span>City</span> : Los Angeles</li>
							<li><span>State</span> : United States</li>
							<li><span>Postcode </span> : 36952</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row order_d_inner">
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Expected Delivery Date</h4>
						<ul class="list">
							<li><span>Order number</span> : 60235</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Status</h4>
						<ul class="list">
							<li><span>Street</span> : 56/8</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="details_item">
						<h4>Current Location</h4>
						<ul class="list">
							<li><span>Street</span> : 56/8</li>
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
							<tr>
								<td>
									<p>Pixelstore fresh Blackberry</p>
								</td>
								<td>
									<h5>x 02</h5>
								</td>
								<td>
									<p>$720.00</p>
								</td>
							</tr>
							<tr>
								<td>
									<p>Pixelstore fresh Blackberry</p>
								</td>
								<td>
									<h5>x 02</h5>
								</td>
								<td>
									<p>$720.00</p>
								</td>
							</tr>
							<tr>
								<td>
									<p>Pixelstore fresh Blackberry</p>
								</td>
								<td>
									<h5>x 02</h5>
								</td>
								<td>
									<p>$720.00</p>
								</td>
							</tr>
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
							<tr>
								<td>
									<h4>Total</h4>
								</td>
								<td>
									<h5></h5>
								</td>
								<td>
									<p>$2210.00</p>
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