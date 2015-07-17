<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlseasonManagement extends sql {
	
	
	var $miConfigurador;
	
	
	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}
	

	function cadena_sql($tipo,$variable="") {
		 
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */
		
		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
		 
		switch($tipo) {
			 
			case "searchSeason":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_season IDSEASON, ";
				$cadena_sql.="name NAME, ";
				$cadena_sql.="color COLOR ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."season ";
				$cadena_sql.="WHERE estado='1' ";
				break;
				
				
			case "insertDay":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."season_calendar ";
				$cadena_sql.="( ";
				$cadena_sql.="`time`, ";
				$cadena_sql.="`id_season`, ";
				$cadena_sql.="`id_commerce`, ";
				$cadena_sql.="`estado` ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="( ";
				$cadena_sql.="'".$variable['day']."', ";
				$cadena_sql.="'".$variable['season']."', ";
				$cadena_sql.="'".$variable['commerce']."', ";
				$cadena_sql.="'1' ";
				$cadena_sql.=")";
				break;
			
			
				
			case "searchDay":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_seasonCalendar IDSEASONCALENDAR ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."season_calendar ";
				$cadena_sql.="WHERE estado='1' ";
				$cadena_sql.=" AND id_commerce = ".$variable['commerce'];
				$cadena_sql.=" AND time = '".$variable['day']."'";
				break;			
				
			case "searchAllDays":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_seasonCalendar IDSEASONCALENDAR, ";
				$cadena_sql.="time TIMEDAY, ";
				$cadena_sql.="id_season IDSEASON ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."season_calendar ";
				$cadena_sql.="WHERE estado='1' ";
				$cadena_sql.=" AND id_commerce = ".$variable['commerce'];
				break;

				
				
			case "updateDay":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."season_calendar ";
				$cadena_sql.="SET ";
				$cadena_sql.="id_season='".$variable['season']."' ";
				$cadena_sql.=" WHERE estado='1' ";
				$cadena_sql.=" AND id_commerce = ".$variable['commerce'];
				$cadena_sql.=" AND time = '".$variable['day']."'";

				break;
				
			case "iniciarTransaccion":
				$cadena_sql="START TRANSACTION";
				break;

			case "finalizarTransaccion":
				$cadena_sql="COMMIT";
				break;

			case "cancelarTransaccion":
				$cadena_sql="ROLLBACK";
				break;

		}

		return $cadena_sql;

	}
}
?>
