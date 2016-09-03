<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlroomsManagement extends sql {


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

			case "commercebyID":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_tipoReserva IDCOMMERCE, ";
				$cadena_sql.="files_folder FILEFOLDER ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tipo_reserva tr ";
				$cadena_sql.="WHERE id_tipoReserva = '".$variable."' ";
				break;

			case "roomListbyCommerce":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_reservable IDRESERVABLE, ";
				$cadena_sql.="nombre NAME, ";
				$cadena_sql.="id_reservableGrupo TYPEROOM, ";
				$cadena_sql.="capacidad CAPACITY ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservable ";
				$cadena_sql.="WHERE tipo_reserva=".$variable['commerce'];
				$cadena_sql.=" AND estado='1'";
				$cadena_sql.=" ORDER BY id_reservable";
				break;

			case "roomTypeListbyCommerce":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_reservable_type IDTYPEROOM, ";
				$cadena_sql.="nombre NAME, ";
				$cadena_sql.="nombre_maquina MACHINENAME, ";
				$cadena_sql.="TRIM(descripcion) DESCRIPTION, ";
				$cadena_sql.="minimo MINIMUN, ";
				$cadena_sql.="tipo_capacidad CAPACITYTYPE, ";
				$cadena_sql.="capacidad CAPACITY ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservable_type ";
				$cadena_sql.="WHERE id_tipoReserva=".$variable['commerce'];
				$cadena_sql.=" AND estado='1'";
				$cadena_sql.=" ORDER BY id_reservable_type";
				break;


			case "priceList":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_reservable_type IDTYPEROOM, ";
				$cadena_sql.="id_temporada SEASON, ";
				$cadena_sql.="guest GUEST, ";
				$cadena_sql.="COP COP, ";
				$cadena_sql.="USD USD ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservable_valor ";
				$cadena_sql.="WHERE estado='1'";
				break;

			case "priceListbyGuest":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_reservable_type IDTYPEROOM FROM ";
				$cadena_sql.=$prefijo."reservable_valor ";
				$cadena_sql.="WHERE estado='1'";
				$cadena_sql.=" AND id_reservable_type=".$variable['idtyperoom'];
				$cadena_sql.=" AND guest='".$variable['guest']."' ";
				break;

			case "deletePricesOverCapacity":
				$cadena_sql="DELETE FROM ";
				$cadena_sql.=$prefijo."reservable_valor ";
				$cadena_sql.=" WHERE id_reservable_type=".$variable['idtyperoom'];
				$cadena_sql.=" AND guest>'".$variable['capacity']."' ";
				break;

			case "typeListRoom":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_reservable_type IDTYPEROOM, ";
				$cadena_sql.="nombre NAME ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservable_type ";
				$cadena_sql.="WHERE estado='1' ";
				$cadena_sql.="AND id_tipoReserva='".$variable['commerce']."'";
				break;
        
			case "listTypeRoomSeason": 
				$cadena_sql="SELECT ";
				$cadena_sql.="min_days MINIMUN, ";
				$cadena_sql.="id_reservable_type IDTYPEROOM, ";
				$cadena_sql.="id_season SEASON ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservable_type_season ";
				break; 

			case "updateDataRoom":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."reservable ";
				$cadena_sql.="SET ";
				$cadena_sql.="nombre='".$variable['name']."',";
				$cadena_sql.="id_reservableGrupo='".$variable['typeroom']."' ";
				$cadena_sql.="WHERE id_reservable=".$variable['idroom'];
				$cadena_sql.=" AND tipo_reserva=".$variable['idcommerce'];
				break;

			case "updateDataTypeRoom":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."reservable_type ";
				$cadena_sql.="SET ";
				$cadena_sql.="nombre='".$variable['name']."',";
				$cadena_sql.="nombre_maquina='".$variable['idtyperoom']."', ";
				$cadena_sql.="descripcion=trim('".$variable['description']."'), ";
				$cadena_sql.="capacidad='".$variable['capacity']."', ";
				$cadena_sql.="minimo='".$variable['minimun']."' ";
				$cadena_sql.="WHERE id_reservable_type=".$variable['idtyperoom'];
				$cadena_sql.=" AND id_tipoReserva=".$variable['idcommerce'];
				break;

			case "updateDataPriceTypeRoom":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."reservable_valor ";
				$cadena_sql.="SET ";
				$cadena_sql.=$variable['currency']."='".$variable['price']."' ";
				$cadena_sql.="WHERE id_reservable_type=".$variable['idtyperoom'];
				$cadena_sql.=" AND id_temporada=".$variable['season'];
				$cadena_sql.=" AND guest='".$variable['guest']."' ";
				break;

			case "deleteRoom":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."reservable ";
				$cadena_sql.="SET ";
				$cadena_sql.="estado='0'";
				$cadena_sql.="WHERE id_reservable=".$variable['idroom'];

				break;

			case "deleteTypeRoom":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."reservable_type ";
				$cadena_sql.="SET ";
				$cadena_sql.="estado='0' ";
				$cadena_sql.="WHERE id_reservable_type=".$variable['idtyperoom'];

				break;
			case "createRoom":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."reservable(nombre,identificador,tipo_reserva,estado)  ";
				$cadena_sql.="VALUES( ";
				$cadena_sql.="'',";
				$cadena_sql.="'',";
				$cadena_sql.="'".$variable['idcommerce']."',";
				$cadena_sql.="'1'";
				$cadena_sql.=") ";
				break;

			case "createTypeRoom":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."reservable_type(nombre,id_tipoReserva,estado)  ";
				$cadena_sql.="VALUES( ";
				$cadena_sql.="'',";
				$cadena_sql.="'".$variable['idcommerce']."',";
				$cadena_sql.="'1'";
				$cadena_sql.=") ";
				break;

			case "createPrices":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."reservable_valor(id_reservable_type,id_temporada,guest,estado)  ";
				$cadena_sql.="VALUES( ";
				$cadena_sql.="'".$variable['idtyperoom']."',";
				$cadena_sql.="'".$variable['season']."',";
				$cadena_sql.="'".$variable['guest']."',";
				$cadena_sql.="'1'";
				$cadena_sql.=") ";
				break;
    
			case "getTypeRoomSeason":
				$cadena_sql="SELECT ";
				$cadena_sql.="min_days MINIMUN ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservable_type_season ";
				$cadena_sql.="WHERE ";
        $cadena_sql.=" id_reservable_type=".$variable['idtyperoom'];
				$cadena_sql.=" AND ";
        $cadena_sql.=" id_season=".$variable['season'];
				break;
        
  		case "insertTypeRoomSeason":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."reservable_type_season(id_reservable_type,id_season,min_days)  ";
				$cadena_sql.="VALUES( ";
				$cadena_sql.="'".$variable['idtyperoom']."',";
				$cadena_sql.="'".$variable['season']."',";
				$cadena_sql.="'".$variable['min_days']."' ";
				$cadena_sql.=") ";
				break;
        
      case "updateTypeRoomSeason":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."reservable_type_season ";
				$cadena_sql.="SET ";
				$cadena_sql.=" min_days=".$variable['min_days']." ";
				$cadena_sql.="WHERE id_reservable_type=".$variable['idtyperoom'];
				$cadena_sql.=" AND id_season=".$variable['season'];
		}

		//echo "<br/><br/>$tipo=".$cadena_sql;

		return $cadena_sql;

	}
}
?>
