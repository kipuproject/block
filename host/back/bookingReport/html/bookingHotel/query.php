<?PHP

		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");

		$query="SELECT ";
		$query.="id_reserva IDBOOKING, ";
		$query.="estado_reserva STATUSBOOKING, "; 
		$query.="fecha_inicio START, ";
		$query.="fecha_fin END, ";
		$query.="from_unixtime(fecha_inicio,'%d') DAY, ";
		$query.="from_unixtime(fecha_inicio,'%m') MONTH, ";
		$query.="from_unixtime(fecha_inicio,'%Y') YEAR, ";
		$query.="ROUND((fecha_fin-fecha_inicio)/86400) DAYS ";
		$query.="FROM ";
		$query.=$prefijo."reserva ";
		$query.="WHERE estado<>0 ";
		$query.="AND estado_reserva NOT IN (3,5) ";

		
		//REPORTE dE DINERO RECIBIDO
		
		//1. TRAER TODAS LAS RESERVAS DEL PERIODO
		//NO DEBEN SER 3 CANCELADA, 5 BLOQUEADA
		
		
		$bookings=$this->miRecursoDB->ejecutarAcceso($query,"busqueda");
		$bookingsByMonth=$this->bookingsByMonth($bookings);
		//$bookingsByMonth=$this->arrayByMonth($bookingsByDate);
			
			
			
		///////////---------------REPORTE dE DINERO RECIBIDO---------------------/////
		
		//1. TRAER TODAS LAS RESERVAS DEL PERIODO
		//NO DEBEN SER 3 CANCELADA, 5 BLOQUEADA
		
		$query="SELECT ";
		$query.="id_reserva IDBOOKING, ";
		$query.="estado_reserva STATUSBOOKING, "; 
		$query.="fecha_inicio START, ";
		$query.="fecha_fin END, ";
		$query.="valor_pagado MONEY_LOCAL, ";
		$query.="valor_total VALUE_BOOKING, ";
		$query.="'0' MONEY_ONLINE, ";  
		$query.="from_unixtime(fecha_inicio,'%d') DAY, ";
		$query.="from_unixtime(fecha_inicio,'%m') MONTH, ";
		$query.="from_unixtime(fecha_inicio,'%Y') YEAR, ";
		$query.="ROUND((fecha_fin-fecha_inicio)/86400) DAYS ";
		$query.="FROM ";
		$query.=$prefijo."reserva ";
		$query.="WHERE estado<>0 ";
		$query.="AND estado_reserva NOT IN (3,5) ";
		
		$bookings=$this->miRecursoDB->ejecutarAcceso($query,"busqueda");
		$allbookings=$this->orderArrayKeyBy($bookings,'IDBOOKING');
		/*echo "<pre>";
		var_dump($allbookings);
		echo "</pre>";*/
		
				
		//2. TRAER TODOS LOS PAGOS ONLINE DEL PERIODO
		//STATUS=1 APROBADOS
		
		$query="SELECT ";
		$query.="system_reference IDBOOKING, ";
		$query.="value MONEY_ONLINE ";  
		$query.="FROM ";
		$query.=$prefijo."payu_payment ";
		$query.="WHERE status=1 ";
		
		$payments=$this->miRecursoDB->ejecutarAcceso($query,"busqueda");
		$allpayments=$this->orderArrayKeyBy($payments,'IDBOOKING');
		/*echo "<pre>";
		var_dump($allpayments);
		echo "</pre>";*/
		
		//Recorro todos los pagos online
		foreach($allpayments as $key=>$value){
			//A cada reserva agrego los datos de pago online 
			//El valor inicial es 0 pero se sustituye con el nuevo 
			//las claves numericas no quedan asociadas con el mismo orden de las consultas
			if(isset($allbookings[$key])){
				$allbookings[$key]=array_merge($allbookings[$key],$allpayments[$key]);
			}		
		}
		
		/*echo "<pre>";
		var_dump($allbookings);
		echo "</pre>";*/
		
		$moneyByMonth=$this->moneyByMonth($allbookings,FALSE);
		$dataMoneyByMonth=$this->moneyByMonth($allbookings,TRUE);
		
		
		

?>	