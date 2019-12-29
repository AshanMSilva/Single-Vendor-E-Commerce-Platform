<?php $this->setSiteTitle('View Order')?>
<!--================ click on registered user's order to view or Enter tracking ID =================-->
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
    <?php ?>

<?php 
		//take the user_id from registered cutomer in session
		$user_id= 3;
		Orders::processOrdersTable($user_id);
?>

<br>

<?php $this->end()?>