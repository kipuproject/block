<!--
<div class="grid" style="margin-bottom:30px">

	<div class="red-button unit one-fifth">
		GENERAL
	</div>

	<div class="red-button  unit one-fifth">
		MOTORES DE RESERVA
	</div>

</div>

<h1><hr/>Filtros<hr/></h1>
	
<div class="grid">
	<div class="widget unit one-quarter">
		<label>PERIODO</label>
		<div class="input100"><input name="period" type="radio" disabled>Anual</div>
		<div class="input100"><input name="period" type="radio" checked >Mensual</div>
		<div class="input100"><input name="period" type="radio" disabled>Semanal</div>
		<div class="input100"><input name="period" type="radio" disabled>Rango</div>
	</div>
	<div class="widget unit one-quarter">
		<label>ESTADO</label>
		<div class="input100"><input type="checkbox" checked >Confirmadas</div>
		<div class="input100"><input type="checkbox" checked disabled>Canceladas</div>
	</div>
-->
	
	<!--div class="widget unit one-quarter">
		<label>TEMPORADA</label>
		<div class="input50"><input type="checkbox" checked >Alta</div>
		<div class="input50"><input type="checkbox" checked >Baja</div>
		<div class="input50"><input type="checkbox" checked >Prom. 1</div>
		<div class="input50"><input type="checkbox" checked >Prom. 2</div>
	</div-->
<!--	
	<div class="widget unit one-quarter">
		<label>MOTOR DE RESERVAS</label>
		<div class="input50"><input type="checkbox" checked disabled>Kipu Web</div>
		<div class="input50"><input type="checkbox" checked disabled>Kipu Hotel</div>
		<div class="input50"><input type="checkbox" checked disabled>Booking</div>
		<div class="input50"><input type="checkbox" checked disabled>Atrapalo</div>
		<div class="input50"><input type="checkbox" checked disabled>Despegar</div>
		<div class="input50"><input type="checkbox" checked disabled>TripAdvisor</div>
		<div class="input50"><input type="checkbox" checked disabled>Expedia</div>
	</div>
	
</div>
<br/>
		<a href="" class="red-button" style="background:#CCC !important; color:#000 !important">Actualizar Reporte</a>

-->




<h1><hr/>Total de Reservas<hr/></h1>

<div class="grid ">
	<div class="charts charts-default unit half"> 
		<div class="charts-heading">
			<span class="glyphicon glyphicon-th"></span>
			Grafica
		</div>
		<div class="charts-body">
			<div id="mygraph"></div>
		</div>
	</div>
	<div class="charts charts-default  unit half">
		<div class="charts-heading">
			<span class="glyphicon glyphicon-th"></span>
			Datos
		</div>
		<div class="charts-body">
			<div id="mydatabookings"></div>
		</div>	
	</div>

</div>

<br/>
<h1><hr/>Recaudos<hr/></h1>

<div class="grid ">
	<div class="charts charts-default unit half"> 
		<div class="charts-heading">
			<span class="glyphicon glyphicon-th"></span>
			Grafica
		</div>
		<div class="charts-body">
			<div id="mygraphmoney"></div>
		</div>
	</div>
	<div class="charts charts-default  unit half">
		<div class="charts-heading">
			<span class="glyphicon glyphicon-th"></span>
			Datos
		</div>
		<div class="charts-body">
			<div id="mydatamoney"></div>
		</div>	
	</div>

</div>


<script>

	$("#dvloader").show();
	
		
	new Morris.Line({
		element: 'mygraph',
		data:<?=$bookingsByMonth?>,
		xkey: 'periodo',
		ykeys: ['total'],
		labels: ['Total Reservas'],
	});
	
	$('#mydatabookings').columns({
		data: <?=$bookingsByMonth?>
	});
	
	new Morris.Line({
		element: 'mygraphmoney',
		data:<?=$moneyByMonth?>,
		xkey: 'periodo',
		ykeys: ['total'], 
		labels: ['Total Recaudos'],
	});
	
	$('#mydatamoney').columns({
		data: <?=$dataMoneyByMonth?>
	});
	
	
	$("#dvloader").hide();
</script>
