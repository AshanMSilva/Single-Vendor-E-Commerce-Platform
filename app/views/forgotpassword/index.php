<?php $this->setSiteTitle('Forgot Password');
    $email= $this->_data;
    //dnd($email);
?>
	
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
<br>
<br>
<br>
	<div class='row'>
		<div class= 'col-sm-6 offset-sm-3'>
			<div class='card'>
				<h3 class='card-header bg-warning text-white'>Forgot Password Email Verification</h3>
				<div class=card-body>
					<div class='row'>
						<div class='col-sm-6'>Your Entered Email Address</div>
						<div class='col-sm-6'><?php echo $email?></div>
					</div>
					<hr>
					<div class='row'>
						<h5>Please enter your code below to reset your password</h5>
					</div>
			
					<form action="<?=PROOT?>forgotpassword/verifycode" method="post" id="" class='row login_form'>
						<div class='form-group'>
							<input type="hidden" name='email' value='<?php echo $email?>'>
						</div>
						<div class='form-group col-md-12'>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Verification Code" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Verification Code'" required>
						</div>
						<div class='form-group'>
							<div class='col-sm-6'>
								<button class='btn btn-warning' type='submit' name='submit'>Submit Code</button>
							</div>
							<div class=''>
								<a href="">Enter Another Email Address</a>
							</div>
						</div>							
					</form>
					<form action="<?=PROOT?>forgotpassword/index" method="post" class='row login_form'>
						<div class='form-group'>
							<input type="hidden" name='email' value='<?php echo $email?>'>
						</div>
						<div class='form-group'>
							<div class='col-sm-6'>
								<button class='btn btn-warning' type='submit' name='submit'>Send Code Again</button>
							</div>
						</div>
					</form>
								
				</div>
			</div>
		</div>
	</div> 
</div>

	<div id="resetpasswordModal" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md" role="content">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Please Enter your New Password</h4>
					<button class="close" type="buttton" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form class="row login_form" action="<?=PROOT?>forgotpassword/resetpassword" method="post" id="">
						<div class='form-group'>
							<input type="hidden" name='email' value='<?php echo $email?>'>
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
						<div class="form-group">
							<button type="submit" value="submit" name="submitnewpassword" class="primary-btn">Submit</button>							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>


<?php $this->end()?>