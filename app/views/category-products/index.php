<?php //$this->setSiteTitle('Home');
	//$topProducts = $this->_data[0];   get top products
?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>

    <?php $data = $this->get_data();
    $category_title = $data['category_title'];
    $cat_products = $data['category_products'];
    $category_array = $data['category_array'];
	// $topProducts = $data['topProducts'];
	//dnd($topProducts);
     //dnd($categories);
     

    function create_list($cat_list){
		echo('<ul class="main-categories">');
		foreach ($cat_list as $key => $value){
			if(is_array($value)){
                $key_without_space = str_replace(' ', '-', $key);
                echo( '<li class="main-nav-list"><a data-toggle="collapse" href="#' . $key_without_space . '" aria-expanded="false" 
                    aria-controls="' . $key_without_space . '"><span class="lnr lnr-arrow-right"></span>' .$key . '<span class="number">(' . count($cat_list[$key]). ')</span></a>
				<ul class="collapse" id="' . $key_without_space . '" data-toggle="collapse" aria-expanded="false" aria-controls="' . $key_without_space . '">');
				create_list($value);
				echo('</ul>');
			}
			else{
				echo('<li class="main-nav-list"><a href="' . $value . '">' . $key . '<span class="number"></span></a></li>');
			}			
		}
		echo('</ul>');
	}
    ?>

    <section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1><?=$category_title?></h1>
					<nav class="d-flex align-items-center">
						<a href="<?=PROOT?>home/index">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Category<span class="lnr lnr-arrow-right"></span></a>
						<a href="#"><?=$category_title?></a>
					</nav>
				</div>
			</div>
		</div>
	</section>
    <!-- End Banner Area -->
    <br>
    <div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
                    <div class="head">Browse Categories</div>
                        <?php create_list($category_array); ?>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row">
                    <?php foreach($cat_products as $product): ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="single-product">
                                <a href="<?=PROOT?>browse/viewProduct/<?=$product->get_product_id()?>">
                                <img class="img-fluid" src="<?=PROOT?>img/product/p1.jpg" alt=""></a>
                                <div class="product-details">
                                    <h6><strong><?=$product->get_title()?></strong></h6>
                                    <h6>From: <strong><?=$product->get_brand()?></strong></h6>
                                    <div class="price">
                                        <h6>$<?=$product->get_min_price()?> - $<?=$product->get_max_price()?></h6>
                                        <!--<h6 class="l-through">$210.00</h6>-->
                                    </div>
                                    <div class="prd-bottom">

                                        <a href="" class="social-info">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">add to bag</p>
                                        </a>
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-heart"></span>
                                            <p class="hover-text">Wishlist</p>
                                        </a>
                                        <!--<a href="" class="social-info">
                                            <span class="lnr lnr-sync"></span>
                                            <p class="hover-text">compare</p>
                                        </a>-->
                                        <a href="" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php $this->end()?>