<?php $this->setSiteTitle('View Orders')?>
<!--================Enter tracking ID and the ordered email address =================-->
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
                <p>To track your order please enter your Order ID in the box below and press the "Track" button. This
                    was given to you on your receipt and in the confirmation email you should have received.</p>
                <form class="row tracking_form" action="<?=PROOT?>tracking/trackorderg" method="post" novalidate="novalidate">
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="order" name="order" placeholder="Order ID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'">
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Billing Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Billing Email Address'">
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" value="submit" name="submit" class="primary-btn">Track Order</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--================End Tracking Box Area =================-->


<?php $this->end()?>