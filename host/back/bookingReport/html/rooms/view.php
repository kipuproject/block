<?php

$indice=0;



$funcion[$indice++]="datatable/jquery.dataTables.min.js";
$funcion[$indice++]="datatable/TableTools.min.js";
$funcion[$indice++]="datatable/ColReorderWithResize.js";
$funcion[$indice++]="datatable/ColVis.min.js";
$funcion[$indice++]="datatable/jquery.dataTables.columnFilter.js";
$funcion[$indice++]="datatable/jquery.dataTables.grouping.js";
$funcion[$indice++]="chosen/chosen.jquery.min.js";
$funcion[$indice++]="eakroko.min.js";
$funcion[$indice++]="application.min.js";
//$funcion[$indice++]="demonstration.min.js";





foreach ($funcion as $clave=>$nombre){
  echo "\n<script type='text/javascript' src='".$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/script/".$nombre."'>\n</script>\n";
}

?>
<script>
jQuery(function($){
   $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '<Ant',
      nextText: 'Sig>',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      weekHeader: 'Sm',
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''};
   $.datepicker.setDefaults($.datepicker.regional['es']);
});
</script>


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
	
<div class="titulob">
	<div class="tituloimg">
		<h1>LISTADO GENERAL DE RESERVAS</h1>
			
	</div>
</div>
<br/>
<script>
	$(function() {
	$( ".datepicker" ).datepicker();
	});
</script>

<div id="filter-form">
	<form>
		Check-in desde <input class="datepicker" type="text" /> hasta <input class="datepicker" type="text" />
		<a class="red-button">Filtrar</a>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="box box-bordered">
			<div class="box-content nopadding">
				<table class="table table-hover table-nomargin table-bordered dataTable dataTable-tools dataTable-columnfilter roomtable"> 
					<thead>
						<tr  class="thefilter">
							<th class='hidden-350'></th>
							<!--th class='hidden-1024'></th-->
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							<th class='hidden-480'></th>
							
						</tr> 
						<tr>
							<th>Habitacion</th>
							<!--th>Ocupacion</th--> 
							<th>Valor Total</th>
							<th>Recaudos Directos</th>
							<th>Recaudos en Linea</th>
							<th>Recaudos Pendientes</th>
						</tr>
					</thead>
					<tbody>
					
					<?PHP
					 
					 foreach($allRooms as $key=>$value){
					
						$value['PENDING']=$value['TOTAL']*1-$value['MONEY_LOCAL']*1-$value['MONEY_ONLINE']*1;
					?>
						<tr>
							<td><?=$rooms[$key]['NAME']?></td>
							<!--td><?="0"?></td-->
							<td class='hidden-350'><?=number_format($value['TOTAL'])?></td>
							<td class='hidden-1024'><?=number_format($value['MONEY_LOCAL'])?></td>
							<td class='hidden-480'><?=number_format($value['MONEY_ONLINE'])?></td>
							<td class='hidden-480' style="color:<?=($value['PENDING']*1)>0?"red":"green"?>" ><?=number_format($value['PENDING'])?></td>
							
						</tr>
					<?PHP
					
					
					}
					
					?>
					
					</tbody>
				</table>
			</div>
			
			
			
		</div>
	</div>
</div>
	