<?php $this->setSiteTitle('Email Validation')?>
	
<?php $this->start('head')?>
<?php //Script::displayscript();
?>

<?php $this->end()?>
<?php $this->start('body')?>

<br>
<br>
<br>
        <div class='row'>
                <div class= 'col-sm-6 offset-sm-3'>
                        <div class='card'>
                                <h3 class='card-header bg-warning text-white'>Email Verification</h3>
                                <div class=card-body>
                                        <div class='row'>
                                                <div class='col-sm-6'>Your Entered Email Address
                                                </div>
                                                <div class='col-sm-6'>email address</div>
                                        </div>
                                        <div class='row'>
                                                <h5>Please click the button below to send the verification code to above email address</h5>
                                        </div>
                                
                                        <form action="<?=PROOT?>email/send" method="post" id="" class='row login_form'>
                                                        <div class='form-group'>
                                                                <input type="hidden" name='email' value='emailaddress'>
                                                        </div>
                                                        <div class='form-group'>
                                                                <div class='col-sm-6'>
                                                                        <button class='btn btn-warning' type='submit' name='submit' >Send Code</button>
                                                                </div>
                                                                <div class='col-sm-6'>
                                                                        <a href="">Enter Another Email Address</a>
                                                                </div>
                                                        </div>
                                                        
                                        </form>
                                                
                                        </div>
                                </div>
                        </div>
                </div> 
        </div>
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
							<input type="number" class="form-control" id="code" name="code" placeholder="Verification Code" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Verification Code'" required>
						</div>
                                                <div class="form-group">
							<button type="submit" value="submit" class="primary-btn">Submit</button>
							
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