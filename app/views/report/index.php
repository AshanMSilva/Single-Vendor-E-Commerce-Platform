
	
<?php $this->start('head')?>

</head>

<?php $this->end()?>

<?php $this->start('body')?>


	<!-- start banner Area -->
    
    
    <!--<section class="banner-area">
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-start">
				<div class="col-lg-12">-->
                
            <!-- Start Search Results Area -->
            <section class="related-product-area section_gap_bottom">
                <div class="container"> 
                    <!-- <br><br><br> -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <div class="section-title">
                            <h1>Quick Reports</h1> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- <div class="row"> -->
                                <div>
                                    <label for="">Product Categories with most Orders</label>
                                    <a href="<?=PROOT?>report/category_orders">View Report</a>       
                                </div>
                                <br>
                                <div>
                                    <label for="">Product With Most NUmber Of Sales</label>
                                    <form action="<?=PROOT?>report/most_sales_products" method="GET">
                                        From :<input type="date" name="from" required>
                                        To: <input type="date" name="to" required>
                                        <button type="submit"> View Report</button>
                                    <!-- <a href="<?=PROOT?>report/most_sales_products">View Report</a>    -->
                                    </form>    
                                </div>
                                <div>
                                    <label for="">Mose interested period</label>
                                    <form action="<?=PROOT?>report/most_reach_period" method="GET">
                                        Product id :<input name="id" type="text">
                                        <button type="submit"> View Report</button>
                                    </form>
                                </div>                               
                             
                                <div>
                                    <form action="<?=PROOT?>report/quartery_report"></form>
                                        Year :<input type="text">
                                        <button type="submit"> View Report</button>
                                </div>
                            <!-- </div> -->
                        </div>
                        <!-- <div class="col-lg-3">
                            <div class="ctg-right">
                                <a href="#" target="_blank">
                                    <img class="img-fluid d-block mx-auto" src="img/category/c5.jpg" alt="">
                                </a>
                            </div>
                        </div> -->
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