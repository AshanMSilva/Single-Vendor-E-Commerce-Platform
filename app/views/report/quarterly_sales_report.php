<?php $this->setSiteTitle('Quarterly Sales Report')?>
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>

<?php 
	//dnd ($data[1]);
	$rec = $data[1];

	$refined = [];
	foreach ($rec as $line) {
		$pid = $line->product_id;
		$refined
	}












 ?>






<section class="tracking_box_area section_gap">
        <div class="container">
        	<br>
        	<br>
           <div class="section-top-border">
				<h3 class="mb-30">Quarterly Sales Report - <?php echo $data[0];?></h3>
				<div class="progress-table-wrap">
					<div class="progress-table">
						<div class="table-head">
							<div class="serial"><h5><sub>Product\</sub><sup>Q</sup></h5></div>
							<div class="visit">Q1</div>
							<div class="visit">Q2</div>
							<div class="visit">Q3</div>
							<div class="visit">Q4</div>
						</div>

						<?php $refined = [1=>[1,2,3,4],2=>[5,6,7,8],3=>[9,10,11,12]] ;		//dnd($refined);			?>



						<!--====================loop========================-->

						<?php 

							foreach ($refined as $key => $value) {
								$title=$key;
								$Q1=$value[0];
								$Q2=$value[1];
								$Q3=$value[2];
								$Q4=$value[3];

							echo 
							'<div class="table-row">
							<div class="serial">'.$title.'</div>
							<div class="visit">'.$Q1.'</div>
							<div class="visit">'.$Q2.'</div>
							<div class="visit">'.$Q3.'</div>
							<div class="visit">'.$Q4.'</div>
							</div>';  
							}


						?>



					</div>
				</div>
			</div>
        </div>
    </section>




<?php $this->end()?>
