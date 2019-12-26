<?php $title=Session::get('title');?>
<?php $this->setSiteTitle($title." | KARMA SHOP" )?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>

<!--================Single Product Area =================-->
<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="../../img/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="../../img/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="../../img/category/s-p1.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo $title;?></h3>
						<h2><?php echo Session::get('productPrice');?></h2>
						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> : <?php echo Session::get('category_name')?></a></li>
							<li><a class="active" href="#"><span>Brand</span> : <?php echo Session::get('brand_name')?></a></li>
							<!-- <li><a href="#"><span>Availibility</span> : In Stock</a></li> -->
                        </ul>
                            <form action="<?=PROOT?>cart/addProduct" method="POST">
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
                                    
                                    <div class="product_count">
                                        <label for="qty">Quantity:</label>
                                        <input type="text" name="quantity" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
                                    </div>
                                    <div class="card_area d-flex align-items-center">
                                        <button class="primary-btn" type="submit">Add To Cart</button> 
                                    </div>
                            </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->


<?php $this->end()?>
 