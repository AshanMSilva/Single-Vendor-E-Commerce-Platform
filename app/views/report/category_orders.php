
	
<?php $this->start('head')?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}

.container {
  width: 100%;

}

.skills {
  text-align: right;
  padding-top: 10px;
  padding-bottom: 10px;
  color: white;
}

.class1 { background-color: #4CAF50;}
.class2 { background-color: #2196F3;}
.class3 { background-color: #f44336;}
.class4 { background-color: #808080;}
.class5 { background-color: red;}
.class6 { background-color: purple;}
.class7 { background-color: black;}
.class8 { background-color: pink;}
.class9 { background-color: yellow;}
.class10 { background-color: green;}

</style>
</head>

<?php $this->end()?>

<?php $this->start('body')?>


	<!-- start banner Area -->
    
    
    <!--<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">-->
                
            <!-- Start Search Results Area -->

            <?php 
            $result=$this->get_data();
            $categories=$result[0];
            $numAll=$result[1];
            ?>
            <section class="related-product-area section_gap_bottom">
                <div class="container"> 
                    <!-- <br><br><br> -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <div class="section-title">
                            <h1>Product Categories with most orders</h1> 
                            </div>
                        </div>
                    </div>
                <?php $i=1; ?>
                <?php foreach($categories as $title => $value):?>
                        <div>
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                                <div class="single-related-product d-flex">
                                   <a href="#"><img src="" alt=""></a>
                                    <?php $p=(double)$value*100/(double)$numAll; ?>
                                    <p><?php echo $title; $i++;  ?></p>
                                        <div class="container">
                                            <div class="skills class<?php echo $i;  ?>" style="width:<?php echo $p."%"?>"  ><?php echo round($p)."%";?></div>
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