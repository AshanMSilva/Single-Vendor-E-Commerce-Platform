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
        if(Session::exists('logged_in')){
            if(Session::get('logged_in')){
                $regcust=$data[2];
                //dnd($regcust->get_house_number());
            }
            else{
                $regcust=null;
            }
        }
        else{
            $regcust=null;
        }
        //dnd($regcust);
        $products= $data[0];
        $total= $data[1];
        // dnd($products);
        
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
                                <th scope="col">SKU</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Total</th>
                                <th scope="col">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php 
                            $price=0;
                            $sku=0;
                            $qty=0;
                            $stock=0;
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
											<a href="<?=PROOT?>browse/viewProduct/<?=$product['product_obj']->get_product_id()?>"> <?php echo $product['product_obj']->get_title()?> </a>
											<?php $attributes = $product['product_obj']->get_variants()[0]->get_attributes();
											//dnd($attributes);
											$atr="";
											foreach($attributes as $key=>$value):
												$atr=$atr.$key." : ".$value.",  ";
                                            endforeach;
                                            $atr = rtrim($atr, ', ');
											?>
											<br>
											<p><?php echo $atr?></p>											
											<input type="text" name="<?php echo 'variant'.$variant ?>" value="<?php echo $product['product_obj']->get_variants()[0]->get_variant_id()?>" hidden>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <p><?php echo $product['product_obj']->get_variants()[0]->get_sku()?></p>
									</div>
                                </td>
                                <td>
									<div class="product_count">
										<input type="text" name="<?php echo 'price'.$price ?>" value="<?php echo $product['product_obj']->get_variants()[0]->get_price()?>" readonly>
									</div>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input class="quantity" type="number" name="<?php echo 'qty'.$qty ?>"  maxlength="12" value="<?php echo $product['quantity']?>" step="1" min="1" title="Quantity:"
                                            class="input-text qty">
                                        
                                    </div>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="<?php echo 'stock'.$stock ?>"  value="<?php echo $product['product_obj']->get_variants()[0]->get_stock()?>" class="input-text qty" readonly>                                        
                                    </div>
                                </td>
                                <td>
									<div class="product_count">
										<input type="text" name="<?php echo 'item_total' ?>" value="" jAutoCalc="{<?php echo 'price'.$price ?>} * {<?php echo 'qty'.$qty ?>}" readonly>
									</div>
                                </td>
                                <td>
                                    <a class="close" type="button" href="<?=PROOT?>myCart/removeFromCart/<?php echo $product['product_obj']->get_variants()[0]->get_variant_id()?>">&times;</a>
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
					<button type="submit" name="update" value="update" class="updatecart genric-btn primary float-right">Update Cart</button>
                   
								
                </form>
                
                
                </div>
                <br>
                
            </div>
            <div class="float-right">
                <a class="genric-btn primary checkout" data-target="#deliveryMethodModel" data-toggle="modal">Checkout</a>
            </div>
        </div>
    </section>
    <div id="billingDetailsModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delivery Details</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
                    <form class="row contact_form" id="DeliveryForm" action="<?=PROOT?>Checkout/confirmDetails" method="post" onsubmit="return validate_delivery_form()">
                        <?php if($regcust == null): ?>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control firstName" id="firstName" name="firstName" placeholder="First Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required>
                                
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control lastName" id="lastName" name="lastName" placeholder="Last Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required>
                                
                            </div>
                        <?php endif; ?>

                        <?php if($regcust == null): ?>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control contactNumber" id="contactNumber" name="contactNumber" placeholder="Contact Number" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Contact Number'" required>
                            </div>
                        <?php else: ?>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control contactNumber" id="contactNumber" name="contactNumber" placeholder="New Contact Number" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'New Contact Number'">
                            </div>
                            <?php
                                $contacts = $regcust->get_contacts();
                                $count = count($contacts);
                            ?>
                            <div class="col-md-6 form-group p_star">
                                <select id="contact_list" name="contact_list" class="">
                                    <option value="no_select" selected="selected">No contact selected</option>
                                    <?php for($i = 0; $i < $count;  $i++): ?>
                                        <option value="<?=$contacts[$i]?>"><?=$contacts[$i]?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <!--<div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="company" name="company" placeholder="Company name">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" name="number">
                            <span class="placeholder" data-placeholder="Phone number"></span>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="email" name="compemailany">
                            <span class="placeholder" data-placeholder="Email Address"></span>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <select class="country_select">
                                <option value="1">Country</option>
                                <option value="2">Country</option>
                                <option value="4">Country</option>
                            </select>
                        </div>-->
                        <div class="col-md-12 form-group p_star">
                            <input type="number" class="form-control houseNumber" id="houseNumber" name="houseNumber" placeholder="House Number"  min="1" onfocus="this.placeholder = ''" onblur="this.placeholder = 'House Number'" required>
                            
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control street" id="street" name="street" placeholder="Street" pattern="[A-Za-z0-9\s]{1,}" title="Should contain only alphanumeric characters" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Street'" required>
                            
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control city" id="city" name="city" placeholder="City" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'City'" required>
                            
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control state" id="state" name="state" placeholder="State" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'State'" required>
                            
                        </div>
                        <!--<div class="col-md-12 form-group p_star">
                            <select class="country_select">
                                <option value="1">District</option>
                                <option value="2">District</option>
                                <option value="4">District</option>
                            </select>
                        </div>-->
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control zipCode" id="zipCode" name="zipCode" placeholder="Zip Code" pattern="[0-9]{5}" title="Should contain only 5 numbers" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Zip Code'" required>
                        </div>
                        <!--<div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="selector">
                                <label for="f-option2">Create an account?</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <h3>Shipping Details</h3>
                                <input type="checkbox" id="f-option3" name="selector">
                                <label for="f-option3">Ship to a different address?</label>
                            </div>
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Order Notes"></textarea>
                        </div>-->
                        <div class="col-md-12 form-group">
                            <button type="submit" name="confirm_details" value="submit" class="genric-btn primary offset-sm-4">Confirm Details</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
    </div>
    


    <div id="pickupDetailsModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Pickup Details</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
                    <form class="row contact_form" id="PickupForm" action="<?=PROOT?>Checkout/confirmDetails" method="post" onsubmit="return validate_pickup_form()">
                        <?php if($regcust == null): ?>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control firstNamep" id="firstName" name="firstName" placeholder="First Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required>
                                
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control lastNamep" id="lastName" name="lastName" placeholder="Last Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required>
                                
                            </div>
                        <?php endif; ?>
                        <!--<div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="company" name="company" placeholder="Company name">
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" name="number">
                            <span class="placeholder" data-placeholder="Phone number"></span>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="email" name="compemailany">
                            <span class="placeholder" data-placeholder="Email Address"></span>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <select class="country_select">
                                <option value="1">Country</option>
                                <option value="2">Country</option>
                                <option value="4">Country</option>
                            </select>
                        </div>-->
                        <!-- <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control contactNumber" id="contactNumber" name="contactNumber" placeholder="Contact Number" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Contact Number'" required>                                
                        </div> -->
                        <?php if($regcust == null): ?>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control contactNumber" id="contactNumber" name="contactNumber" placeholder="Contact Number" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Contact Number'" required>
                            </div>
                        <?php else: ?>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control contactNumber" id="contactNumber" name="contactNumber" placeholder="New Contact Number" pattern="[0-9]{10}" title="10 digit phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'New Contact Number'">
                            </div>
                            <?php
                                $contacts = $regcust->get_contacts();
                                $count = count($contacts);
                            ?>
                            <div class="col-md-6 form-group p_star">
                                <select id="contact_list" name="contact_list" class="">
                                    <option value="no_select" selected="selected">No contact selected</option>
                                    <?php for($i = 0; $i < $count;  $i++): ?>
                                        <option value="<?=$contacts[$i]?>"><?=$contacts[$i]?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        <?php endif; ?>                            
                            
                        <div class="col-md-12 form-group">
                            <button type="submit" name="confirm_details" value="submit" class="genric-btn primary offset-sm-4">Confirm Details</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>


    <div id="deliveryMethodModel" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delivery Method</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body offset-sm-2">
                    <a class="genric-btn primary" href="" data-toggle="modal" data-dismiss="modal" data-target="#pickupDetailsModal">Store PickUp</a>
                    <a class="genric-btn primary" data-target="#billingDetailsModal" data-toggle="modal" data-dismiss="modal">Home Delivery</a>
				</div>
			</div>
		</div>
	</div>
<?php if($regcust!=null): ?>
    <script>
        document.querySelector(".houseNumber").value=<?php echo $regcust->get_house_number()?>;
        // document.querySelector(".firstName").value="<?php //echo $regcust->get_first_name()?>";
        //console.log(document.querySelector(".stated"));
        // document.querySelector(".lastName").value="<?php //echo $regcust->get_last_name()?>";
        // document.querySelector(".firstNamep").value="<?php //echo $regcust->get_first_name()?>";
        //console.log(document.querySelector(".stated"));
        // document.querySelector(".lastNamep").value="<?php //echo $regcust->get_last_name()?>";
        document.querySelector(".state").value="<?php echo $regcust->get_state()?>";
        //console.log(document.querySelector(".stated"));
        document.querySelector(".city").value="<?php echo $regcust->get_city()?>";
        document.querySelector(".zipCode").value="<?php echo $regcust->get_zipcode()?>";
        document.querySelector(".street").value="<?php echo $regcust->get_street()?>";
        //console.log(document.querySelector(".houseNumber").value);
    
    
    function validate_delivery_form(){
        var form = document.getElementById('DeliveryForm');
        if(form.elements.namedItem("contactNumber").value != "" && form.elements.namedItem("contact_list").value != "no_select"){
            alert("You should insert a new contact or select an existing contact. Do not do both");
            return false;
        }
        else if(form.elements.namedItem("contactNumber").value == "" && form.elements.namedItem("contact_list").value == "no_select"){
            alert("Please provide a new contact number or select one of your contact numbers");
            return false;
        }
        else{
            return true;
        }
    }

    function validate_pickup_form(){
        var form = document.getElementById('PickupForm');
        if(form.elements.namedItem("contactNumber").value != "" && form.elements.namedItem("contact_list").value != "no_select"){
            alert("You should insert a new contact or select an existing contact. Do not do both");
            return false;
        }
        else if(form.elements.namedItem("contactNumber").value == "" && form.elements.namedItem("contact_list").value == "no_select"){
            alert("Please provide a new contact number or select one of your contact numbers");
            return false;
        }
        else{
            return true;
        }
    }
    </script>

<?php else: ?>
    <script>
    function validate(){
        return true;
    }

    function validate_pickup_form(){
        return true;
    }
    </script>
<?php endif; ?>

<?php } ?>


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
            /*document.querySelector(".checkout").onclick = function(){
                alert("Update cart to enable checkout.");
                // document.querySelector(".checkout").data-target = "";
            }*/
            document.querySelector(".checkout").disabled=true;
            document.querySelector(".checkout").title='Checkout is diasbled. Update cart to enable checkout';
        }
        })();

        document.oninput = setEnabled;
        document.onchange = setEnabled;
 </script>
 
<?php $this->end()?>
