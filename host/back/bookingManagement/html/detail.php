<style>

.detailBooking li {
  line-height: 20px;
  padding: 10px;
  margin: 0px;
  border: 1px solid #CCC;
}

.detailBooking li label{
  width: 200px;
  float: left;
  font-weight: bold;
}

</style>


<div id="main_user">
	<br/><br/>
	<div class="accordion accordion-widget" id="accordion3">

		<?php foreach($bookings as $ibooking): ?>
		<div class="accordion-group blue">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#c1<?=$ibooking?>">
					<?php
					    $infoBooking=explode('-',$ibooking);

					    echo date("d-M-Y",$infoBooking[0]);

					    if($infoBooking[0]<>$infoBooking[2]){
					      echo " (RESERVA PRINCIPAL: ". date("d-M-Y",$infoBooking[2]).")";
					    }

					?>
				</a>
			</div>
			<div id="c1<?=$ibooking?>" class="accordion-body collapse in">
				<?php
					$clients=$this->getBookinsbyDate($ibooking,$commerce);
					$i=0;
					while(isset($clients[$i][0])){
						//$clients[$i] Reserva con todos los datos
						$this->managementBooking($clients[$i],$typeRooms);
						$i++;
					}
				?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>


</div>
