
	
<?php $this->start('head')?>

<link rel="stylesheet" href="<?=PROOT?>css/report.css">

<?php $this->end()?>

<?php $this->start('body')?>


	<!-- start banner Area -->
    
    
    <!--<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">-->
                
            <!-- Start Search Results Area -->

            <?php 
            $data=$this->get_data();
            $products=$data[0];
            $numAll=$data[1];
            $date1=$data[2][0];
            $date2=$data[2][1];
            ?>
            <section class="related-product-area section_gap_bottom">
                <div class="container"> 
                    <!-- <br><br><br> -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <div class="section-title">
                            <h1>Most Sales Products</h1> 
                            </div>
                        </div>
                    </div>
                <?php $i=1; ?>
                <?php echo "Period :".$date1." - ".$date2;?>
                <br>
                <?php foreach($products as $title => $value):?>
                        <div>
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                                <div class="single-related-product d-flex">
                                   <a href="#"><img src="" alt=""></a>
                                    
                                   <?php $p=round((double)$value*100/(double)$numAll); ?>
                                    <p><?php echo $title; $i++;  ?></p>
                                        <div class="container">
                                            <div class="skills class<?php echo $i;  ?>" style="width:<?php echo $p."%";?>"  ><?php echo $p."%";?></div>
                                        </div>
                                </div>
                            </div>
                        </div>
                <?php endforeach?>
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