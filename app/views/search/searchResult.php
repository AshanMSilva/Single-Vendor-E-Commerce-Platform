<?php $this->setSiteTitle('search result')?>
	
<?php $this->start('head')?>

<?php $this->end()?>

<?php $this->start('body')?>


	<!-- start banner Area -->
    
    
   <!-- <section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">-->
                
            <!-- Start Search Results Area -->

            <?php 
            $x=Session::get('x');
            $prodDetails=Session::get('prodDetails');
            ?>
            <section class="related-product-area section_gap_bottom">
                <div class="container">
                    <!-- <br><br><br> -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <div class="section-title">
                            <h1>Search Results for "<?php echo $x;?> "</h1>
                            </div>
                        </div>
                    </div>
                

                <?php foreach($prodDetails as $product_id => $details):?>
                    <?php 
                        $title=$details['title'];
                        $minPrice=$details['minPrice'];
                        $maxPrice=$details['maxPrice'];?>
                        <div>
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                                <div class="single-related-product d-flex">
                                    <!-- <a href="#"><img src="../../img/r1.jpg" alt=""></a> -->
                                    <div class="desc">
                                    <a href="<?=PROOT?>singleproduct/productDisplay?id=<?php echo $product_id?>&title=<?php echo $title;?>" class="title"><?php echo $title;?></a>
                                        <div class="price">
                                        <?php 
                                            if ($maxPrice==$minPrice){
                                                $price=$maxPrice;
                                            }
                                            else{
                                                $price= $minPrice." - ".$maxPrice;
                                            }
                                            Session::set('productPrice',$price);
                                            echo "<h6>".$price."</h6>"
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endforeach?>
                <?php if(count($prodDetails)==0){
                    echo "<h2>No Result Found!</h2>";
                }?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                
                            

                            </div>
                        </div>
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
            <!-- End Search Results Area -->
	<!--			</div>
			</div>
		</div>
	</section>-->
	<!-- End banner Area -->
    


<?php $this->end()?>
 
