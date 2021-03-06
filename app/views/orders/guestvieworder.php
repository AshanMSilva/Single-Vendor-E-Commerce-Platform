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
                <form class="row tracking_form" action="<?=PROOT?>orders/trackbyid" method="post" novalidate="novalidate">
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" id="track" name="track" placeholder="Tracking ID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tracking ID'">
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