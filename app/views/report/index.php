<?php $this->start('head')?>


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
                                <br>
                                <br>
                            <h1>Reports</h1> 
                            </div>
                        </div>
                    </div>
                    


                    <div class="container border-top-generic">
                            <h3 class="text-heading">Quarterly Sales</h3>
                            <div class="button-group-area mt-40">
                            
                             
                                <div>
                                    <form action="<?=PROOT?>report/quarterly_sales_report" method = 'post'>
                                        Year :<input id="year" name="year" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'year'"
                                 required class="single-input" required>
                                        <button type="submit" class="genric-btn success circle"> View Report</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>


                    <div class="row">
                        <div class="col-lg-12">
                            <!-- <div class="row"> -->
                        <div class="container border-top-generic">
                            <h3 class="text-heading">Most Ordered Product Categories</h3>
                            <div class="button-group-area mt-40">
                                <div>
                                    <a href="<?=PROOT?>report/category_orders" class = 'genric-btn success circle'>View Report</a>       
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="container border-top-generic">
                            <h3 class="text-heading">Sales of Product by Period</h3>

                            <div class="button-group-area mt-40">
                                <div>
                                    <form action="<?=PROOT?>report/most_sales_products" method="POST">
                                        From :<input type="date" name="from" onfocus="this.placeholder = ''" onblur="this.placeholder = 'From'"
                                 required class="single-input" required>
                                        To: <input type="date" name="to" onfocus="this.placeholder = ''" onblur="this.placeholder = 'To'"
                                 required class="single-input" required>
                                        <button type="submit" class="genric-btn success circle"> View Report</button>
                                    <!-- <a href="<?=PROOT?>report/most_sales_products">View Report</a>    -->
                                    </form>    
                                </div>
                            </div>
                        </div>


                        <br>
                        <br>




                        <div class="container border-top-generic">
                            <h3 class="text-heading">Product's Interest with Time</h3>
                            <div class="button-group-area mt-40">
                                <div>
                                    <form action="<?=PROOT?>report/most_reach_period" method="GET">
                                        Product id :<input name="id" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Product ID'"
                                 required class="single-input" required>
                                        <button type="submit" class="genric-btn success circle"> View Report</button>
                                    </form>
                                </div>   
                            </div>
                        </div>


                        <br>
                        <br>



                        
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