<?php $this->setSiteTitle('Cart')?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
    <?php
		$data = $this->get_data();
		if(empty($data[0])){
			//dnd($data);
			?>
			<h2>There is no items in your cart</h2>
		<?php
		}
		else{
			//dnd($data);
		
        //dnd($data);
        $products= $data[0];
        $total= $data[1];
        //dnd($total);
        
            //$title = $product->get_title();
            //dnd($products[0]['product_obj']->get_product_id());
        
        //dnd($data);
    ?>
    
    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                <form name="cart" action="<?=PROOT?>myCart/updateCart" method="post">
			
					<table class="table" name="cart">
                        <thead>
                            <tr >
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
							$price=0;
							$qty=0;
							$prod=0;
							$variant=0;
							$count=0;
							foreach($products as $product):
								
								
								?>
                            <tr name="line_items">
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="../../img/cart.jpg" alt="">
                                        </div>
                                        <div class="media-body">
											<p><?php echo $product['product_obj']->get_title()?></p>
											<?php $attributes = $product['product_obj']->get_variants()[0]->get_attributes();
											//dnd($attributes);
											$atr="";
											foreach($attributes as $key=>$value):
												$atr=$atr.$key." : ".$value.",  ";
											endforeach;
											?>
											<br>
											<p><?php echo $atr?></p>
											<input  type="text" name="<?php echo 'product'.$prod ?>" value="<?php echo$product['product_obj']->get_product_id()?>" hidden>
											<input type="text" name="<?php echo 'variant'.$variant ?>" value="<?php echo $product['product_obj']->get_variants()[0]->get_variant_id()?>" hidden>
                                        </div>
                                    </div>
                                </td>
                                <td>
									<div class="product_count">
										<input type="text" name="<?php echo 'price'.$price ?>" value="<?php echo $product['product_obj']->get_variants()[0]->get_price()?>" readonly>
									</div>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input class="quantity" type="number" name="<?php echo 'qty'.$qty ?>"  maxlength="12" value="1" step="1" min="0" title="Quantity:"
                                            class="input-text qty">
                                        
                                    </div>
                                </td>
                                <td>
									<div class="product_count">
										<input type="text" name="<?php echo 'item_total' ?>" value="" jAutoCalc="{<?php echo 'price'.$price ?>} * {<?php echo 'qty'.$qty ?>}" readonly>
									</div>
                                </td>
							</tr>
							<?php 
								$price++;
								//dnd($price);
								$qty++;
								
								$prod++;
								$variant++;
								$count++; 
						endforeach;?>
							<tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
									<div class="product_count">
										<input type="text" name="sub_total" value="" jAutoCalc="SUM({item_total})" readonly>
									</div>
                                </td>
                            </tr>
						</tbody>
					</table>
					<input type="number" name="count" value="<?php echo $count ?>" hidden>
					<button type="submit" name="submit" value="submit" class="updatecart genric-btn primary float-right">Update Cart</button>
                   
								
                </form>
                
                
                </div>
                <br>
                
            </div>
            <div class="float-right">
                <a class="genric-btn primary checkout" data-target="#verficationCodeModal" data-toggle="modal">Checkout</a>
            </div>
        </div>
    </section>
    <div id="verficationCodeModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Enter Verification Code</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form class="row login_form" action="<?=PROOT?>email/verifycode" method="post" id="">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="code" name="code" placeholder="Verification Code" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Verification Code'" required>
						</div>
						<div class="form-group">
							<button type="submit" value="submit" name="submitcode" class="primary-btn">Submit</button>							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php }?>

    <!--================End Cart Area =================-->

 <script>
        const inputs = document.querySelectorAll(".quantity");
        //console.log(inputs);
        for (const el of inputs){
        el.oldValue = el.value ;
        
        }

        // Declares function and call it directly
        var setEnabled;
        (setEnabled = function() {
        var e = true;
        for (const el of inputs) {
            if (el.oldValue !== (el.value)) {
            e = false;
            break;
            }
        }
        
        document.querySelector(".updatecart").disabled = e;
        //console.log(!e)
        if(document.querySelector(".updatecart").disabled){
            document.querySelector(".checkout").disabled=false;
            document.querySelector(".checkout").title='';
            
            //console.log( document.querySelector(".updatecart").title);
           
        }
        else{
            document.querySelector(".checkout").disabled=true;
            document.querySelector(".checkout").title='Button is diasble. Update cart to enable button';
        }
        })();

        document.oninput = setEnabled;
        document.onchange = setEnabled;
 </script> 
<?php $this->end()?>
