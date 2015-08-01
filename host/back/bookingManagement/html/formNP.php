<form action="index.php" method="POST" class='form-horizontal form-bordered'>
  <div class="control-group" style="width:20%; float:left">
    <div for="textfield" class="labelSup">/</div>
    <?php foreach($grid['LABELS'] as $idlabelroom=>$label): ?>
        <div  id="room_<?=$idlabelroom?>" class="labelSup "> 
          <?=$label?>
        </div>
    <?php endforeach; ?>
  </div>
  <?php 
  for($i=1;$i<=$numDaysMonth;$i++):
  ?>
  <div class="control-group" style="width:<?=$widthCell?>%; float:left"> <? /* width:<?=$widthCell?>% */?>
    <div for="textfield" class="labelSup" ><?=$i?></div>
    <?php 
      foreach($grid['BOOKING'][$i] as $value): 

        $totalAdults = 0;
        $totalChildren = 0;
        $Infants = 0;
        $classColor = "";

        if(isset($bookings[$value])){
          $numBookings = count($bookings[$value]);
          
          $bbc = 0; //se recorren todas las reservas q pertenecen a la misma celda
          while(isset($bookings[$value][$bbc]['IDCELL'])){
            $totalAdults = $bookings[$value][$bbc]['NUMGUEST']+$totalAdults;	
            $totalChildren = $bookings[$value][$bbc]['NUMKIDS']+$totalChildren;
            $bbc++;
          }
          if($numBookings > 0){
            $infoCell = $bookings[$value][0]['INFOCELL'];
          }else{
            $infoCell = "-";
          }
          $classColor = "";
          if($numBookings > 0){
            $classColor = "grey";
          }

          $state = $bookings[$value][0]['STATEBOOKING']; 

          if($state == 5){

            $classColor = "black";

          }elseif($state == 6){

            $classColor = "yellow";

          }elseif($state == 2){

            $classColor = "green";

          }
        }else{
          $numBookings = 0;
          $state = "";
        }
      ?>
        <div style="width:95%; border:1px solid #FFFFFF" >
          <div id='<?php echo $value; ?>-<?php echo $bookings[$value][0]['DATESTART']; ?>' title="Adultos:<?=$totalAdults?> Niños:<?=$totalChildren?>" class="clickableElement <?=$classColor?>"  id="">
            <?php
              if($state<>5){
                echo $numBookings;
              }else{
                echo "B";
              }
            ?>
          </div>	
        </div>	
    <?php 
      endforeach;
    ?>
  </div>
  <?php endfor; ?>
</form>