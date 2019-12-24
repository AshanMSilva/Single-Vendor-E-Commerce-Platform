<?php $title=Session::get('title');?>
<?php $this->setSiteTitle($title." | KARMA SHOP" )?>
	
<?php $this->start('head')?>

<?php $this->end()?>

<?php $this->start('body')?>
<!-- start banner Area -->
    <section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">
                <!-- Start product Area -->
                    <section class="related-product-area section_gap_bottom">
                        <div class="container">
                            
                            <div class="row justify-content-center">
                                <div class="col-lg-6 text-center">
                                    <div class="section-title">
                                    <h1><?php echo $title;?> </h1>
                                    </div>
                                </div>
                            </div>
                                <form action="../controllers/addToCart.php" method="POST">
                                    <?php $attributes=$_SESSION["attributes"];?> 
                                    <table>
                                        <div >
                                        <?php foreach($attributes as $attri_name=> $values):?>
                                            <th>
                                                <label for=""><?php echo $attri_name;?></label>
                                                <select name="<?php echo $attri_name;?>">
                                                    <?php  for($a=0;$a<count($values);$a++):?>
                                                        <option value="<?php echo $values[$a];?>" ><?php echo $values[$a];?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </th>
                                        <?php endforeach;?>
                                        </div>     
                                    </table>
                                    <div>
                                        <label for="">Quantity</label>
                                        <input type="number" name="quantity" class="col-1">
                                    </div>
                                    <button type="submit">Add To Cart</button> 
                                </form>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="ctg-right">
                                        <a href="#" target="_blank">
                                            <img class="img-fluid d-block mx-auto" src="img/category/c5.jpg" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End product Area -->
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->


<?php $this->end()?>
 