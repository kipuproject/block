<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqluserComment extends sql {


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

			/**
			 * Clausulas específicas
			 */

			case "api_key":
				$cadena_sql="SELECT ";
				$cadena_sql.="dbms DBMS, ";
				$cadena_sql.="id_tipoReserva IDCOMMERCE, ";
				$cadena_sql.="files_folder FOLDER ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."commerce ";
				$cadena_sql.="WHERE estado=1 ";
				$cadena_sql.="AND api_key='".$variable."'";
				break;

			case "getIP":
				$cadena_sql="SELECT ";
				$cadena_sql.="count(ip) ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."comment ";
				$cadena_sql.="WHERE ip = '".$variable['ip']."' ";
				$cadena_sql.=" AND date >= ".$variable['today'];
				break;

			case "getComments":
				$cadena_sql="SELECT ";
				$cadena_sql.="comment, ";
				$cadena_sql.="username, ";
				$cadena_sql.="rating ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."comment ";
				$cadena_sql.="WHERE id_commerce = '".$variable['commerce']."' ";
				$cadena_sql.="ORDER BY date DESC  ";
				break;

			case "insertComment":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."comment ";
				$cadena_sql.="( ";
				$cadena_sql.="`id_commerce`, ";
				$cadena_sql.="`comment`, ";
				$cadena_sql.="`username`, ";
				$cadena_sql.="`rating`, ";
				$cadena_sql.="`id_booking`, ";
				$cadena_sql.="`date`, ";
				$cadena_sql.="`ip` ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="( ";
				$cadena_sql.="'".$variable['commerce']."', ";
				$cadena_sql.="'".$variable['comments']."', ";
				$cadena_sql.="'".$variable['username']."', ";
				$cadena_sql.="'".$variable['rating']."', ";
				$cadena_sql.="'".$variable['booking']."', ";
				$cadena_sql.="'".time()."', ";
				$cadena_sql.="'".$variable['ip']."' ";
				$cadena_sql.=")";
				break;
		}
			//echo "<br/>".$tipo."=".$cadena_sql;
    return $cadena_sql;


	}
}



?>
