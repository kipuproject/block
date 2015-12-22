<?PHP

		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");

			
		///////////---------------REPORTE DE DINERO RECIBIDO---------------------/////
		
		//1. TRAER TODAS LAS RESERVAS DEL PERIODO
		//NO DEBEN SER 3 CANCELADA, 5 BLOQUEADA
		
		$query="SELECT ";
		$query.="r.id_reserva IDBOOKING, ";
		$query.="rr.id_reservable IDROOM, ";
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
		$query.=$prefijo."reserva r ";
		$query.="INNER JOIN ";
		$query.=$prefijo."reserva_reservable rr ";
		$query.="ON r.id_reserva=rr.id_reserva ";
		$query.="WHERE estado<>0 ";
		$query.="AND estado_reserva NOT IN (3,5) ";
		
		$bookings=$this->miRecursoDB->ejecutarAcceso($query,"busqueda");
		$allbookings=$this->orderArrayMultiKeyBy($bookings,'IDROOM','IDBOOKING');
		
		/*echo "<pre>";
		var_dump($allbookings);
		echo "</pre>";*/
		
				
		//2. TRAER TODOS LOS PAGOS ONLINE DEL PERIODO
		//STATUS=1 APROBADOS
		
		$query="SELECT ";
		$query.="system_reference IDBOOKING, ";
		$query.="value MONEY_ONLINE, ";  
		$query.="rr.id_reservable IDROOM ";
		$query.="FROM ";
		$query.=$prefijo."payu_payment pp ";
		$query.="INNER JOIN ";
		$query.=$prefijo."reserva_reservable rr ";
		$query.="ON pp.system_reference=rr.id_reserva ";
		$query.="WHERE status=1 ";
		
		$payments=$this->miRecursoDB->ejecutarAcceso($query,"busqueda");
		$allpayments=$this->orderArrayMultiKeyBy($payments,'IDROOM','IDBOOKING');
		
		/*echo "<pre>";
		var_dump($allpayments);
		echo "</pre>";*/
		
		//Recorro todos los pagos online
		foreach($allpayments as $room=>$booking){
			//A cada reserva agrego los datos de pago online 
			//El valor inicial es 0 pero se sustituye con el nuevo 
			//las claves numericas no quedan asociadas con el mismo orden de las consultas
			
			foreach($booking as $id=>$value){
				if(isset($allbookings[$room][$id])){
					$allbookings[$room][$id]=array_merge($allbookings[$room][$id],$allpayments[$room][$id]);
				}		
			}
			
		}
		
		/*echo "<pre>";
		var_dump($allbookings);
		echo "</pre>";*/
		
		
		foreach($allbookings as $room=>$booking){
			foreach($booking as $id=>$value){ 
				$allRooms[$room]['TOTAL']=$allRooms[$room]['TOTAL']*1+$value['VALUE_BOOKING']*1;
				$allRooms[$room]['MONEY_ONLINE']=$allRooms[$room]['MONEY_ONLINE']*1+$value['MONEY_ONLINE']*1;
				$allRooms[$room]['MONEY_LOCAL']=$allRooms[$room]['MONEY_LOCAL']*1+$value['MONEY_LOCAL']*1;
			}		
		} 
		
		$query="SELECT ";
		$query.="id_reservable IDROOM, ";
		$query.="nombre NAME ";
		$query.="FROM ";
		$query.=$prefijo."reservable ";
		$query.="WHERE ";
		$query.="estado <> '0' ";
		$rooms=$this->miRecursoDB->ejecutarAcceso($query,"busqueda");
		$rooms=$this->orderArrayKeyBy($rooms,'IDROOM');
		$rooms['0']['NAME']="Sin Asignar";
		
		

?>	