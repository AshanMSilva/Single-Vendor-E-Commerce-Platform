<?php $this->setSiteTitle('View Order')?>
<!--================ click on registered user's order to view or Enter tracking ID =================-->
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
    <!--================Tracking Box Area =================-->
    <section class="tracking_box_area section_gap">
        <div class="container">
            <div class="tracking_box_inner">
            	<br>
            	<br>
                <p>To track your order please enter your Order ID in the box below and press the "Track" button.</p>
                <form class="row tracking_form" action="<?=PROOT?>tracking/trackorderu" method="post" novalidate="novalidate">
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="order" name="order" placeholder="Order ID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'">
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" value="submit" name="submit" class="primary-btn">Track Order</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--================End Tracking Box Area =================-->

    <!--================Order_details Area =================-->
<div class="whole-wrap pb-100">
		<div class="container">
    			<div class="section-top-border">
				<h3 class="mb-30">Previous orders</h3>
				<div class="progress-table-wrap">
					<div class="progress-table">
						<div class="table-head">
							<div class="serial">Order ID</div>
							<div class="country">Date</div>
							<div class="visit">Total Price</div>
							<div class="visit">Current Location</div>
							<div class="visit">	</div>
						</div>
						<?php Orders::displayRow(1);?>
						<?php Orders::displayRow(2);?>
						<?php Orders::displayRow(3);?>

					</div>

				</div>
			</div>
	</div>
</div>
<br>
    <!--================End Order details Area =================-->

<?php $this->end()?>