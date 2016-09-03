<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlservicesManagement extends sql {


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


		switch($tipo) {

			/**
			 * Clausulas específicas
			 */


			case "serviceListbyCommerce":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_servicio IDSERVICE, ";
				$cadena_sql.="nombre NAME, ";
				$cadena_sql.="TRIM(descripcion) DESCRIPTION, ";
				$cadena_sql.="online ONLINE, ";
				$cadena_sql.="dinamico DYNAMIC, ";
				$cadena_sql.="id_reservable_type IDTYPEROOM, ";
				$cadena_sql.="pago_unico ONPAYMENT ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."servicio ";
				$cadena_sql.="WHERE id_comercio=".$variable['commerce'];
				$cadena_sql.=" AND estado='1'";
				$cadena_sql.=" ORDER BY nombre";
				break;


			case "priceList":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_servicio IDSERVICE, ";
				$cadena_sql.="id_temporada SEASON, ";
				$cadena_sql.="COP COP, ";
				$cadena_sql.="USD USD ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."servicio_valor ";
				$cadena_sql.="WHERE estado='1'";
				break;

			case "priceListbyGuest":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_reservable_grupo IDTYPEROOM FROM ";
				$cadena_sql.=$prefijo."reservable_valor ";
				$cadena_sql.="WHERE estado='1'";
				$cadena_sql.=" AND id_reservable_grupo=".$variable['idservice'];
				$cadena_sql.=" AND guest='".$variable['guest']."' ";
				break;

			case "deletePricesOverCapacity":
				$cadena_sql="DELETE FROM ";
				$cadena_sql.=$prefijo."reservable_valor ";
				$cadena_sql.=" WHERE id_reservable_grupo=".$variable['idservice'];
				$cadena_sql.=" AND guest>'".$variable['capacity']."' ";
				break;


			case "updateDataService":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."servicio ";
				$cadena_sql.="SET ";
				$cadena_sql.="nombre='".$variable['name']."',";
				$cadena_sql.="pago_unico='".$variable['onepayment']."',";
				$cadena_sql.="descripcion=trim('".$variable['description']."') ";
				$cadena_sql.="WHERE id_servicio=".$variable['idservice'];
				$cadena_sql.=" AND id_comercio=".$variable['idcommerce'];
				break;

			case "updateDataValueService":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."servicio_valor ";
				$cadena_sql.="SET ";
				$cadena_sql.=$variable['currency']."='".$variable['price']."' ";
				$cadena_sql.="WHERE id_servicio=".$variable['idservice'];
				$cadena_sql.=" AND id_temporada=".$variable['season'];
				break;


			case "deleteService":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."servicio ";
				$cadena_sql.="SET ";
				$cadena_sql.="estado='0' ";
				$cadena_sql.="WHERE id_servicio=".$variable['idservice'];

				break;


			case "createService":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."servicio(nombre,id_comercio,estado)  ";
				$cadena_sql.="VALUES( ";
				$cadena_sql.="'',";
				$cadena_sql.="'".$variable['idcommerce']."',";
				$cadena_sql.="'1'";
				$cadena_sql.=") ";
				break;

			case "createPrices":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."servicio_valor(id_servicio,id_temporada,estado)  ";
				$cadena_sql.="VALUES( ";
				$cadena_sql.="'".$variable['idservice']."',";
				$cadena_sql.="'".$variable['season']."',";
				$cadena_sql.="'1'";
				$cadena_sql.=") ";
				break;



			case "companyListAll":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_establecimiento IDCOMPANY, ";
				$cadena_sql.="id_parent IDPARENT ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."establecimiento ";
				break;

			case "commerceFilterList":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_filtroOpcion IDOPTION ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tipo_reserva_filtrador ";
				$cadena_sql.="WHERE id_tipoReserva IN (".$variable.") ";
				$cadena_sql.="AND estado<>0";
				break;

		}

		//echo "<br/><br/>$tipo=".$cadena_sql;

		return $cadena_sql;

	}
}
?>
