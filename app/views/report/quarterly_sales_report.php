<?php $this->setSiteTitle('Quarterly Sales Report')?>
<?php $this->start('head')?>

<?php $this->end()?>
<?php $this->start('body')?>

<?php 
	//dnd ($data[1]);
	$db=DB::getInstance();
	$pidrec= $db->select('products','product_id');
	// dnd($pidrec[0]);
	$pidarray = [];
	foreach ($pidrec as $value) {
		$p = $value->product_id;
		$pidarray[$p] =  array(0,1,2,3,4,5,6,7,8);
		//array_push($pidarray,$q );
	}
	//dnd($pidarray);
	$rec = $data[1];

	$pidarray = [];
	foreach ($rec as $line) {
		$pid = $line->product_id;
		$quarter = $line->Q;
		$product_name = $line->title;
		$product_total = $line->product_total;
		$product_qty = $line->product_quantity;
		$pidarray[$pid][4] = $product_name;
		switch ($quarter) {
			case 1:
				$pidarray[$pid][0] = $product_total;
				$pidarray[$pid][5] = $product_qty;
				break;
			case 2:
				$pidarray[$pid][1] = $product_total;
				$pidarray[$pid][6] = $product_qty;
				break;
			case 3:
				$pidarray[$pid][2] = $product_total;
				$pidarray[$pid][7] = $product_qty;
				break;
			case 4:
				$pidarray[$pid][3] = $product_total;
				$pidarray[$pid][8] = $product_qty;
				break;
			
			// default:
			// 	$pidarray[$pid][1] = $product_total;
			// 	break;
		}
	}
				//dnd($pidarray);













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
							<div class="serial">Product_Name</div>
							<div class="visit"></div>
							<div class="visit">Q1</div>
							<div class="visit">Qty</div>
							<div class="visit">Q2</div>
							<div class="visit">Qty</div>
							<div class="visit">Q3</div>
							<div class="visit">Qty</div>
							<div class="visit">Q4</div>
							<div class="visit">Qty</div>
						</div>

						<?php //$pidarray = [1=>[1,2,3,4],2=>[5,6,7,8],3=>[9,10,11,12]] ;		//dnd($pidarray);			?>



						<!--====================loop========================-->

						<?php 

							foreach ($pidarray as $value) {
								$title=$value[4];
								$Q1 = (isset($value[0])) ? $value[0] : '--' ;
								$Q2 = (isset($value[1])) ? $value[1] : '--' ;
								$Q3 = (isset($value[2])) ? $value[2] : '--' ;
								$Q4 = (isset($value[3])) ? $value[3] : '--' ;
								$Qty1 = (isset($value[5])) ? $value[5] : '--' ;
								$Qty2 = (isset($value[6])) ? $value[6] : '--' ;
								$Qty3 = (isset($value[7])) ? $value[7] : '--' ;
								$Qty4 = (isset($value[8])) ? $value[8] : '--' ;

							echo 
							'<div class="table-row">
							<div class="serial">'.$title.'</div>
							<div class="visit">'.'</div>
							<div class="visit">'.$Q1.'</div>
							<div class="visit">'.$Qty1.'</div>
							<div class="visit">'.$Q2.'</div>
							<div class="visit">'.$Qty2.'</div>
							<div class="visit">'.$Q3.'</div>
							<div class="visit">'.$Qty3.'</div>
							<div class="visit">'.$Q4.'</div>
							<div class="visit">'.$Qty4.'</div>
							</div>';  
							}


						?>



					</div>
				</div>
			</div>
        </div>
    </section>




<?php $this->end()?>
