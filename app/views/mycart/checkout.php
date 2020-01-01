<?php $this->setSiteTitle('Checkout')?>
	
<?php $this->start('head')?>

<script src="<?=PROOT?>js/dist/credit_card_jquery.min.js"></script>

<?php $this->end()?>
<?php $this->start('body')?>
<?php //Alert::displayscriptalert();
    $data = $this->get_data();
    if(isset($data['reg_cust'])){
        $name = $data['reg_cust']['first_name'] . ' ' . $data['reg_cust']['last_name'];
    }
    else{
        $name = $data['guest_cust']['first_name'] . ' ' . $data['guest_cust']['last_name'];
    }
    $cart = $data['cart'];
    $prod_count = count($cart);
?>

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
    <div class="container">
        <!--<div class="returning_customer">
            <div class="check_title">
                <h2>Returning Customer? <a href="#">Click here to login</a></h2>
            </div>
            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new
                customer, please proceed to the Billing & Shipping section.</p>
            <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                <div class="col-md-6 form-group p_star">
                    <input type="text" class="form-control" id="name" name="name">
                    <span class="placeholder" data-placeholder="Username or Email"></span>
                </div>
                <div class="col-md-6 form-group p_star">
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="placeholder" data-placeholder="Password"></span>
                </div>
                <div class="col-md-12 form-group">
                    <button type="submit" value="submit" class="primary-btn">login</button>
                    <div class="creat_account">
                        <input type="checkbox" id="f-option" name="selector">
                        <label for="f-option">Remember me</label>
                    </div>
                    <a class="lost_pass" href="#">Lost your password?</a>
                </div>
            </form>
        </div>
        <div class="cupon_area">
            <div class="check_title">
                <h2>Have a coupon? <a href="#">Click here to enter your code</a></h2>
            </div>
            <input type="text" placeholder="Enter coupon code">
            <a class="tp_btn" href="#">Apply Coupon</a>
        </div>-->
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-4">
                    <h3>Delivery Details</h3>
                    <!-- <form class="row contact_form" action="#" method="post" novalidate="novalidate"> -->
                    <div class="col-md-12 form-group p_star">
                        <p>Customer: <?=$name?></p>
                    </div>                        
                    <div class="col-md-6 form-group p_star">
                        <p>Phone Number: <?=$data['contact']?> </p>
                    </div>
                    <!-- <div class="col-md-6 form-group p_star">
                        <p>Email: </p>
                    </div>                         -->
                    <div class="col-md-12 form-group p_star">
                        <?php if(isset($data['delivery_address'])): ?>
                            <h5>Delivery Address </h5>
                            <p>
                                House Number: <?=$data['delivery_address']['house_number']?> <br>
                                Street: <?=$data['delivery_address']['street']?> <br>
                                City: <?=$data['delivery_address']['city']?> <br>
                                State: <?=$data['delivery_address']['state']?> <br>
                                Postal Code: <?=$data['delivery_address']['zip_code']?>
                            </p>
                            <p>Estimated Delivery Date: <?=$data['estimated_date']?> </p>
                        
                        <?php else: ?>
                            <p>Order will be available from <strong><?=$data['available_date']?></strong>. <br>
                                You can pick it up from our main warehouse. <br> </p>
                            <p> Warehouse location : <br>
                                <strong>C Stores, <br>                                 
                                Main Road, <br>
                                Cleveland, <br>
                                Texas.</strong> <br> </p>
                            <p>Your order will be cancelled if you couldn't pick it up <strong>within 30 days</strong>.
                            </p>
                        <?php endif; ?>
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
                    <!-- </form> -->
                </div>
                <div class="col-lg-8">
                    <div class="order_box">
                        <div class="order_details_table">
                            <h2>Order Details</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Product</th>
                                            <th scope="col">SKU</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i = 0; $i < $prod_count; $i++): ?>
                                            <tr>
                                                <td>
                                                    <p><?=$cart[$i]['title']?></p>
                                                </td>
                                                <td>
                                                    <p><?=$cart[$i]['sku']?></p>
                                                </td>
                                                <td>
                                                    <h5><?=$cart[$i]['quantity']?></h5>
                                                </td>
                                                <td>
                                                    <?php
                                                        $sub_total = $cart[$i]['price'] * $cart[$i]['quantity'];
                                                        $sub_total = number_format($sub_total, 2, '.', ',')
                                                    ?>
                                                    <p>$<?=$sub_total?></p>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>                                            
                                        <tr>
                                            <td>
                                                <h4>Total Price</h4>
                                            </td>
                                            <td>
                                                <h5></h5>
                                            </td>
                                            <td>
                                                <h5></h5>
                                            </td>
                                            <td>
                                                <?php $total = number_format($data['total'], 2, '.', ','); ?>
                                                <h5>$<?=$total?></h5>
                                            </td>
                                        </tr>                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form action="<?=PROOT?>checkout/confirmCheckout" method ="post" onsubmit="return validate()">                                
                            <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="method" value="cash" onclick="toggle_text_input()">
                                    <label for="f-option6">Cash On Delivery </label>
                                    <!-- <img src="../../img/product/card.jpg" alt=""> -->
                                    <div class="check"></div>
                                </div>
                                <p>You can complete your payment at the delivery</p>
                            </div>
                            <div class="payment_item">
                                <div class="radion_btn">                                        
                                    <input type="radio" id="f-option5" name="method" value="card" onclick="toggle_text_input()">
                                    <label for="f-option5">Card Payment</label>
                                    <?php if(Session::exists('registered_customer')): ?>

                                        <?php $count = count($data['reg_cust']['cards']); ?>
                                        <p>Insert a new card or select one from the dropdown</p>
                                    <div class="row">
                                        <div class="col-sm-6">
                                        <select id="card_list" name="card_list" class="col-sm-10 offset-col-1">
                                            <option value="no_select" selected="selected">No card selected</option>
                                            <?php for($i = 0; $i < $count;  $i++): ?>
                                                <option value="<?=$data['reg_cust']['cards'][$i]?>"><?=$data['reg_cust']['cards'][$i]?></option>
                                            <?php endfor; ?>
                                        </select>
                                        </div>
                                    <?php endif; ?>
                                                                                               
                                    <div class="col-sm-6">
                                    <input class="col-sm-10 offset-col-1 form-control" type="text" name="card_number" id="card_num" value="" placeholder="card number" pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" disabled>
                                    </div>
                                    </div>
                                </div>                                
                            
                            <!--<div class="creat_account">
                                <input type="checkbox" id="f-option4" name="selector">
                                <label for="f-option4">I’ve read and accept the </label>
                                <a href="#">terms & conditions*</a>
                            </div>-->
                            <!-- <a class="primary-btn" href="#">Proceed to Paypal</a> -->
                            <div class="col-md-12 form-group">
                                <button class="genric-btn primary radius col-6 offset-sm-3" type="submit" name="confirm_checkout" value="confirm">Confirm Checkout</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function toggle_text_input() {
        if(document.getElementById("f-option5").checked == true){
            $elem = document.getElementById("card_list");
            if($elem){
                $elem.disabled = false;
            }
            else{
                document.getElementById("card_num").required = true;
            }
            // document.getElementById("card_list").disabled = false;
            document.getElementById("card_num").disabled = false;                
            // document.getElementById("card_num").required = true;
        }
        if(document.getElementById("f-option6").checked == true){
            $elem = document.getElementById("card_list");
            if($elem){
                $elem.disabled = true;
            }
            else{
                document.getElementById("card_num").required = false;
            }
            // document.getElementById("card_list").disabled = true;
            document.getElementById("card_num").disabled = true;                
            // document.getElementById("card_num").required = false;
        }
    }

    function validate(){
        if(document.getElementById("f-option5").checked == false && document.getElementById("f-option6").checked == false){
            alert("Please select a payment method and confirm your order");
            return false;
        }
        else if(document.getElementById("f-option5").checked == true && document.getElementById("card_num").value != "" && document.getElementById("card_list").value != "no_select"){
            alert("You should insert a new card or select an existing card. Do not do both");
            return false;
        }
        else if(document.getElementById("f-option5").checked == true && document.getElementById("card_num").value == "" && document.getElementById("card_list").value == "no_select"){
            alert("Please select a card from the list or insert a new card number.");
            return false;
        }
        else{
            return true;
        }
    }

    $('#card_num').on('keyup', function(e){
    var val = $(this).val();
    var newval = '';
    val = val.replace(/\s/g, '');
    for(var i=0; i < val.length; i++) {
        if(i%4 == 0 && i > 0) newval = newval.concat(' ');
        newval = newval.concat(val[i]);
    }
    $(this).val(newval);
});
</script>
<!--================End Checkout Area =================-->

<?php $this->end()?>