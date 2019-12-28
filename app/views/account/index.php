<?php $this->setSiteTitle('Account Details')?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>

    <?php
        $data = $this->get_data();
        $accountDetails = $data['accountDetails'];
        //dnd($accountDetails);

    ?>
        <div class="section-top-border">
				<div class="row">
					<div class="col-lg-8 col-md-8">
						<h3 class="mb-30">Account Details</h3>
						<form class="row login_form" action="" method="post" onsubmit="return validate()" id="detailsForm">
								<div class="col-md-6 form-group">
									<input type="text" class="form-control" id="firstName" name="first_name" placeholder="First Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last Name" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required>
								</div>
								<div class="col-md-12 form-group">
									<input type="email" class="form-control" id="email" name="email" placeholder="Email Address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@#!%*?&]).{6,20}" 
									title="Must contain at least one number and one uppercase and lowercase letter, at least one special character and at least 6 or more characters without spaces" 
									onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
								</div>
								<div class="col-md-6 form-group">
									<input type="password" class="form-control" id="re-password" name="re-password" placeholder="Re-Password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[$@#!%*?&]).{6,20}" 
									title="Must contain at least one number and one uppercase and lowercase letter, at least one special character and at least 6 or more characters without spaces" 
									onfocus="this.placeholder = ''" onblur="this.placeholder = 'Re-Password'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="number" class="form-control" id="houseNumber" name="house_number" placeholder="House Number" min="1" onfocus="this.placeholder = ''" onblur="this.placeholder = 'House Number'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="street" name="street" placeholder="Street" pattern="[A-Za-z0-9\s]{1,}" title="Should contain only alphanumeric characters" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Street'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="city" name="city" placeholder="City" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'City'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="state" name="state" placeholder="State" pattern="[A-Za-z\s]{1,}" title="Allowed alphabetic characters only" onfocus="this.placeholder = ''" onblur="this.placeholder = 'State'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									<input type="text" class="form-control" id="zipCode" name="zip_code" placeholder="Zip Code" pattern="[0-9]{5}" title="Should contain only 5 numbers" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Zip Code'" required>
								</div>
								<div class="col-md-6 col-lg-4 form-group">
									
								</div>
                                <!--for loop for input contact numbers -->
								
								<div class="col-md-12 col-lg-6 offset-lg-3 form-group">
									<button type="submit" value="submit" class="primary-btn" name="submit" id="submit">Update Details</button>
									<!--<a href="">Already have an Account?</a>-->
								</div>
							</form>
					</div>
                    <div class="col-lg-3 col-md-4">
                        <br>
                        <br>
                        <a class="primary-btn col-lg-12 col-6 offset-sm-3 offset-md-0 text-center" href="<?=PROOT?>myCart">Cart</a>
                        <br>
                        <br>
                        <a class="primary-btn col-lg-12 col-6 offset-sm-3 offset-md-0 text-center" href="">Orders</a>
                        <br>
                        <br>
                        <a class="primary-btn col-lg-12 col-6 offset-sm-3 offset-md-0 text-center" href="">Messages</a>
									<!--<a href="">Already have an Account?</a>-->
						
                    </div>
                </div>
            </div>
    
            <script>
	function validate(){
		var form = document.getElementById('detailsForm');
		var password = form.elements.namedItem("password").value;
		var re_password = form.elements.namedItem("re-password").value;		
		if(password != re_password){
			alert("Password and Re-Password fields should be same");
			return false;
		}
		else{				
			return true;
		}		
	}
	</script>
        

<?php $this->end()?>