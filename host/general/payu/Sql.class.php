<?php
if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlPayu extends sql {

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


			case "insertTransaction":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."payu_payment ";
				$cadena_sql.="( ";
				$cadena_sql.="`id_user`, ";
				$cadena_sql.="`id_commerce`, ";
				$cadena_sql.="`system_reference`, ";
				$cadena_sql.="`value`, ";
				$cadena_sql.="`currency`, ";
				$cadena_sql.="`description`, ";
				$cadena_sql.="`date_start`, ";
				$cadena_sql.="`status` ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";
				$cadena_sql.="( ";
				$cadena_sql.="'".$variable['customer']."', ";
				$cadena_sql.="'".$variable['idCommerce']."', ";
				$cadena_sql.="'".$variable['referenceCode']."', ";
				$cadena_sql.="'".$variable['value']."', ";
				$cadena_sql.="'".$variable['currency']."', ";
				$cadena_sql.="'".$variable['description']."', ";
				$cadena_sql.="now(), ";
				$cadena_sql.="'0' ";
				$cadena_sql.=")";
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

			case "searchTransaction":
				$cadena_sql="SELECT  ";
				$cadena_sql.="pp.system_reference SYSTEMREFERENCE, ";
				$cadena_sql.="pp.description DESCRIPTION, ";
				$cadena_sql.="pp.id_payu_reference IDPAYMENT, ";
				$cadena_sql.="pp.value VALUE, ";
				$cadena_sql.="pp.id_commerce IDCOMMERCE, ";
				$cadena_sql.="pp.answer ANSWER, ";
				$cadena_sql.="pp.currency CURRENCY ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."payu_payment pp ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="pp.id_payu_reference='".$variable['idPayment']."' ";
				$cadena_sql.="AND ";
				$cadena_sql.="pp.id_commerce='".$variable['commerce']."' ";
				$cadena_sql.="AND ";
				$cadena_sql.="pp.status=0 ";
				break;

			case "searchTransactionbyBooking":
				$cadena_sql="SELECT  ";
				$cadena_sql.="pp.system_reference SYSTEMREFERENCE, ";
				$cadena_sql.="pp.description DESCRIPTION, ";
				$cadena_sql.="pp.id_payu_reference IDPAYMENT, ";
				$cadena_sql.="pp.value VALUE, ";
				$cadena_sql.="pp.id_commerce IDCOMMERCE, ";
				$cadena_sql.="pp.answer ANSWER, ";
				$cadena_sql.="pp.currency CURRENCY ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."payu_payment pp ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="pp.system_reference='".$variable['booking']."' ";
				$cadena_sql.="AND ";
				$cadena_sql.="pp.id_commerce='".$variable['commerce']."' ";
				break;

			case "dataCommerce":
				$cadena_sql="SELECT  ";
				$cadena_sql.="pc.merchant_id MERCHANTID, ";
				$cadena_sql.="pc.account_id ACCOUNTID, ";
				$cadena_sql.="pc.confirmationURL CONFIRMATIONURL, ";
				$cadena_sql.="pc.responseURL RESPONSEURL, ";
				$cadena_sql.="pc.api_key APIKEY, ";
				$cadena_sql.="pc.api_login APILOGIN ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."payu_config pc ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="pc.id_commerce='".$variable."' ";
				break;


			case "apiCommerceByID":
				$cadena_sql="SELECT  ";
				$cadena_sql.=$prefijo."commerce.api_key APIKEY ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."commerce ";
				$cadena_sql.="WHERE ";
				$cadena_sql.=$prefijo."commerce.id_tipoReserva ='".$variable."' ";
				break;

			case "dataCommerceByID":
				$cadena_sql="SELECT  ";
				$cadena_sql.=$prefijo."commerce.nombre NAME, ";
				$cadena_sql.=$prefijo."commerce.descripcion DESCRIPTION, ";
				$cadena_sql.=$prefijo."commerce.telefono PHONE, ";
				$cadena_sql.=$prefijo."commerce.longitud LONGITUDE, ";
				$cadena_sql.=$prefijo."commerce.latitud LATITUDE, ";
				$cadena_sql.=$prefijo."commerce.facebook FACEBOOK, ";
				$cadena_sql.=$prefijo."commerce.datos_cuenta BANKACCOUNT, ";
				$cadena_sql.=$prefijo."commerce.files_folder FOLDER, ";
				$cadena_sql.=$prefijo."commerce.imagen LOGO, ";
				$cadena_sql.=$prefijo."commerce.correo EMAIL ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."commerce ";
				$cadena_sql.="WHERE ";
				$cadena_sql.=$prefijo."commerce.id_tipoReserva ='".$variable."' ";
				break;

      case "dataBookingByID":
				$cadena_sql="SELECT ";
				$cadena_sql.="r.id_reserva IDBOOKING, ";
				$cadena_sql.="DATE_FORMAT(FROM_UNIXTIME(r.fecha_inicio),'%m/%d/%Y') CHECKIN, ";
				$cadena_sql.="DATE_FORMAT(FROM_UNIXTIME((r.fecha_fin)+2),'%m/%d/%Y') CHECKOUT, ";
				$cadena_sql.="r.fecha_inicio CHECKIN_UNIXTIME, ";
				$cadena_sql.="r.fecha_fin CHECKOUT_UNIXTIME, ";
				$cadena_sql.="r.observacion_cliente OBSERVATION_CLIENT, ";
				$cadena_sql.="'0' INFANTS, ";
				$cadena_sql.="r.cliente CLIENT, ";
				$cadena_sql.="r.tipo_reserva COMMERCE, ";
				$cadena_sql.="r.valor_total VALUE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservation r ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="r.id_reserva ='".$variable."' ";
			break;

      case "dataRoomBookingbyID":
				$cadena_sql="SELECT ";
				$cadena_sql.="rg.nombre NAME, ";
        $cadena_sql.="r.cliente CLIENT, ";
				$cadena_sql.="r.tipo_reserva COMMERCE, ";
				$cadena_sql.="r.valor_total VALUE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."reservation r ";
				$cadena_sql.="INNER JOIN ";
				$cadena_sql.=$prefijo."reservation_reservable rr ";
				$cadena_sql.="ON ";
				$cadena_sql.="rr.id_reserva = r.id_reserva ";
				$cadena_sql.="INNER JOIN ";
				$cadena_sql.=$prefijo."reservable_type rg ";
				$cadena_sql.="ON ";
				$cadena_sql.="rr.id_reservable_type = rg.id_reservable_type ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="r.id_reserva ='".$variable."' ";
			break;

      case "updateDataCommerceByReference":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."payu_payment ";
				$cadena_sql.="SET ";
				$cadena_sql.="answer='".$variable['answer']."', ";
				$cadena_sql.="status='".$variable['status']."' ";
				$cadena_sql.="WHERE id_payu_reference=".$variable['reference'];
				break;

		}
		//echo "<br/>".$tipo."=".$cadena_sql;
		return $cadena_sql;

	}
}
