<?php $this->setSiteTitle('View Order')?>
<!--================ click on registered user's order to view or Enter tracking ID =================-->
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
    <?php ?>

<?php 
		//take the user_id from registered cutomer in session
		if (isset($_SESSION['registered_customer'])) {
			$user_id=$_SESSION['registered_customer'];
			Orders::processOrdersTable($user_id);

		} else {
			echo "<br><br><section class = 'section_gap'><div class = 'container'><h3>please login before you continue</h3></div></section>";
		}
		
		
?>

<br>

<?php $this->end()?>