<?php
$indice=0;
$funcion[$indice++]="datatable/jquery.dataTables.min.js";
$funcion[$indice++]="datatable/TableTools.min.js";
$funcion[$indice++]="datatable/ColReorderWithResize.js";
$funcion[$indice++]="datatable/ColVis.min.js";
$funcion[$indice++]="datatable/jquery.dataTables.columnFilter.min.js";
$funcion[$indice++]="datatable/jquery.dataTables.grouping.js";
$funcion[$indice++]="chosen/chosen.jquery.min.js";
$funcion[$indice++]="eakroko.min.js";
$funcion[$indice++]="application.min.js";
$funcion[$indice++]="demonstration.min.js";

foreach ($funcion as $clave=>$nombre){
  echo "\n<script type='text/javascript' src='".$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/script/".$nombre."'>\n</script>\n";
}

?>
<style>
.menu_calendar > li > a {
    color: #FFFFFF;
    display: block;
    padding: 10px 15px;
	border:1px solid #FFFFFF;
}

.menu_calendar > li {
    float: left;
    margin: 0;
    position: relative;
}

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<br/>
	<ul class="main-nav menu_calendar">
			<li class="btn-calendar">
				<a href="<?=$formSaraDataBookingList?>"><span>VER CALENDARIO</span></a>
			</li>
	</ul>
	<br/><br/><br/>
<div class="titulob">
	<div class="tituloimg">
		<h1>LISTADO GENERAL DE RESERVAS</h1>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="box box-bordered">
 			<div class="box-content nopadding">
      <!--  Seleccione el año de consulta: 
      <select>
        <option>2016</option>
      </select-->
				<table class="table table-hover table-nomargin table-bordered dataTable dataTable-tools dataTable-columnfilter bookingtable"> 
					<thead>
						<tr  class="thefilter">
							<!--th></th-->
							<th></th>
							<th class='hidden-350'></th>
							<th class='hidden-350'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							
							<!--th class='hidden-480'></th-->
						</tr> 
						<tr>
							<!--th>Creacion</th-->
							<th>Origen</th>
							<th>Habitacion</th>
              <th>Responsable</th>
							<th>Check In <br/> dd-mm-yyyy</th>
							<th>Check Out <br/> dd-mm-yyyy</th>
							<th>ADU</th>
							<th>NIÑ</th>
							<th>Notas <br/> Cliente</th>
							<th>Notas <br/> Hotel</th>
							<th>Valor</th>
							<th>Estado</th>
							<th>Abono</th>
							<th>Saldo</th>
							<!--th class='hidden-480'></th-->
						</tr>
					</thead>
					<tbody>
					<?php
					setlocale(LC_ALL,"es_ES"); 
					$i=0;
					while(isset($bookings[$i][0])):
            $id = $bookings[$i]['IDBOOKING'];
            $abono = isset($payments[$id])?$payments[$id ][0]['VALUE']:0;
            $local = !empty($bookings[$i]['LOCALPAYMENT'])?$bookings[$i]['LOCALPAYMENT']:0;
            $abono = $abono + $local;
            
					?>
						<tr>
							<td><?=$bookings[$i]['SOURCE']?></td> 
							<td class='hidden-350'><?=$bookings[$i]['NAMERESERVABLE']?></td>
              <td class='hidden-480'><?=$users[$bookings[$i]['CUSTOMER']][0]['NAMECLIENT']?></td> 
							<td class='hidden-1024'><?=date("d-m-Y",strtotime($bookings[$i]['DATESTART']))?></td>
							<td class='hidden-480'><?=date("d-m-Y",strtotime($bookings[$i]['DATEEND']))?></td> 
							<td class='hidden-480'><?=$bookings[$i]['NUMGUEST']?></td> 
							<td class='hidden-480'><?=$bookings[$i]['NUMKIDS']?></td> 
							<td class='hidden-480'><?=$bookings[$i]['OBSERVATION_CUSTOMER']?></td>
							<td class='hidden-480'><?=$bookings[$i]['OBSERVATION']?></td>
							<td class='hidden-480'><?=$bookings[$i]['PAYMENT']?></td>
							<td class='hidden-480'><?=($statusBoooking[$bookings[$i]['STATEBOOKING']])?></td>
              
							<td class='hidden-480'><?=$abono?></td>
							<td class='hidden-480'><?=($bookings[$i]['PAYMENT']-$abono)?></td>
              
						</tr>
					<?php
          $i++;
          endwhile;
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
  <a target="_blank" href="<?php echo $formSaraDataAllReport; ?>">Descargar Reporte Completo</a>
</div>