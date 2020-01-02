<?php $this->setSiteTitle('Wish List')?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
    <?php 
        $wishlist = $this->get_data();
        
        //dnd($wishlist);
        if (empty($wishlist)) {
        ?>
            <h2>There is no items in your wishlist</h2>
        <?php
        }
        else{
            //dnd($wishlist);
        ?>
            <div class="row">
					<!-- single product -->
					<?php foreach($wishlist as $product): ?>
					<div class="col-lg-3 col-md-6">
						<div class="single-product">
							<img class="img-fluid" src="<?=PROOT?>img/product/p1.jpg" alt="">
							<div class="product-details">
								<h6><strong><?=$product->get_title()?></strong></h6>
								<h6>From: <strong><?=$product->get_brand()?></strong></h6>
								<div class="price">
									<h6>$<?=$product->get_min_price()?> - $<?=$product->get_max_price()?></h6>
									<!--<h6 class="l-through">$210.00</h6>-->
								</div>
								<div class="prd-bottom">

									<!--<a href="" class="social-info">
										<span class="ti-bag"></span>
										<p class="hover-text">add to bag</p>
									</a>-->
									<a href="<?=PROOT?>browse/viewProduct/<?=$product->get_product_id()?>" class="social-info">
										<span class="lnr lnr-move"></span>
										<p class="hover-text">view more</p>
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				
				</div>
        <?php
        }
    ?>
<?php $this->end()?>