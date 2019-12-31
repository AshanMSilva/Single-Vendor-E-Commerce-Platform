<?php $this->setSiteTitle('Product Details'); ?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
<?php 
    $data = $this->get_data();
    $product = $data['product'];    
    $table_headers = $data['table_headers'];
    $variants = $data['variants'];
    $belong_categories = $data['belonging_categories'];
    $variant_count = count($variants);
    $attribute_count = count($table_headers);
    $cat_count = count($belong_categories);
    $cat_str = '';
    for($i = 0; $i < $cat_count; $i++){
        $href = PROOT . 'browse/loadCategories/' . $belong_categories[$i]['category_id'];
        $title = $belong_categories[$i]['title'];
        $cat_str .= '<a class="active" href="' . $href . '">' . $title . '</a>' . ',  ';
    }
    $cat_str = rtrim($cat_str, ',  ');
    // dnd($cat_str);
?>

    <!--<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Product Details Page</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
						<a href="single-product.html">product-details</a>
					</nav>
				</div>
			</div>
		</div>-->
	</section>
    <!-- End Banner Area -->
    
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
						<h3><?=$product->get_title()?></h3>
						<!-- <h2>$149.99</h2> -->
						<ul class="list">                           
							<li><span>Category</span> : <?=$cat_str?></li>
                            <li><span>Brand</span> : <?=$product->get_brand()?></li>
                            <br>
                            <li><span>Available Product Variants</span> : </li>
                        </ul>
                        <form action="#">
							<ul>
                            <?php for($i = 0; $i < $variant_count; $i++): ?>
								<li class="filter-list"><input class="pixel-radio" type="radio" id="variant<?=$i+1?>" name="brand" required><label for="apple">Variant - <?=$i+1?></label></li>
                            <?php endfor; ?>	
                            </ul> 
                            <br>                       
                            <div class="product_count">
                                <label for="qty">Quantity:</label>
                                <input type="number" name="qty" id="sst" min=1 value="1" title="Quantity:" class="input-number qty">
                                </div>
                            <div class="card_area d-flex align-items-center">
                                <button type="submit" name="addToCart" value="Add To Cart" class="primary-btn">Add to Cart</button>
                                <!-- <a class="icon_btn" href="#"><i class="lnr lnr lnr-diamond"></i></a> -->
                                <!-- <a class="icon_btn" href="#"><i class="lnr lnr lnr-heart"></i></a> -->
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <section class="product_description_area">
		<div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Product Variant</th>
                        <?php foreach($table_headers as $header): ?>
                            <th><?=$header?></th>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i < $variant_count; $i++): ?>
                            <tr>
                                <td>Variant - <?=$i+1?></td>
                                <!-- <td><input class="pixel-radio" type="radio" id="variant<?//=$i+1?>" name="brand"><label for="apple">Variant - <?//=$i+1?></label></td> -->
                                <?php for($j = 0; $j < $attribute_count; $j++): ?>
                                    <td><?=$variants[$i][$j]?></td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php $this->end()?>