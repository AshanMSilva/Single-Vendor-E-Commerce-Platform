<?php $this->setSiteTitle('View Order')?>
<!--================ click on registered user's order to view or Enter tracking ID =================-->
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>
    <?php Alert::displayscriptalert();?>
    <?php ?>

<?php Orders::processTable(1);?>

<br>

<?php $this->end()?>