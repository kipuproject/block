<?php
if(!isset($GLOBALS["autorizado"])){
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("plugin/mail/class.phpmailer.php");
include_once("plugin/mail/class.smtp.php");
include_once("core/builder/Acceso.class.php");

class ApiPayu{

	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $miInspectorHTML;
	var $error;
	var $miRecursoDB;
	var $crypto;
	var $mensaje;
	var $status = "";

	function __construct(){
		$this->miConfigurador = Configurador::singleton();
		$this->miInspectorHTML = InspectorHTML::singleton();
		$this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");
    $this->rutaURL = $this->miConfigurador->getVariableConfiguracion("host");
		$this->rutaURL .= $this->miConfigurador->getVariableConfiguracion("site");
	  $this->Access = Acceso::singleton();
	  $conexion = "master";
	  $this->master_resource = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
	}

	public function setRuta($unaRuta){
		$this->ruta = $unaRuta;
	}

	public function setSql($a){
		$this->sql = $a;
	}

	public function setFuncion($funcion){
		$this->funcion = $funcion;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje = $lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario = $formulario;
	}

	public function process(){

		if(!isset($_REQUEST['key'])){
			echo "error";
			exit;
		}else{
			$cadena_sql = $this->sql->cadena_sql("api_key",$_REQUEST['key']);
			$commerce = $this->master_resource->ejecutarAcceso($cadena_sql,"busqueda");
			$this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($commerce[0]['DBMS']);
		  $this->commerce = $commerce[0]['IDCOMMERCE'];
			$this->commerce_folder = $commerce[0]['FOLDER'];
		}

		$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);
		$_REQUEST=$this->miInspectorHTML->limpiarSQL($_REQUEST);

		unset($_REQUEST['aplicativo']);
		unset($_REQUEST['PHPSESSID']);

		foreach($_REQUEST as $key=>$value){
			$_REQUEST[urldecode($key)]=urldecode($value);
		}

		if(isset($_REQUEST['method'])){

			switch($_REQUEST['method']){
				case 'payugo':
					$result = $this->payuGO($_REQUEST['value']);
				break;
				case 'payu-action-url':
					$result = $this->getActionUrl();
				break;
				case 'payu-data':
					$result = $this->getDataPaymentByBookingID($_REQUEST['value']);
				break;
				case 'payu-order-verify':
					$result = $this->orderVerify($_REQUEST['value']);
				break;
			}

			$json=json_encode($result);
			if(isset($_GET['callback'])){
				echo "{$_GET['callback']}($json)";
			}else{
				echo $json;
			}
 		}else{
				echo "no data";
		}
	}

  private function getDataPaymentByBookingID($booking){
    $response = new stdClass();

    $variable['booking'] = $booking;
    $variable['commerce'] = $this->commerce;

    $string_sql = $this->sql->cadena_sql("searchTransactionbyBooking",$variable);
    $result = $this->miRecursoDB->ejecutarAcceso($string_sql,"busqueda");

    if(is_array($result)){

      $result = $result[0];
      $result['ANSWER'] = json_decode($result['ANSWER']);

      //Si no tiene merchantid no es la primer respuesta recibida
      if(empty($result['ANSWER']->merchantId)){
        //echo "NO TIENE";
       // echo "<pre>"; var_dump($result['ANSWER']); echo "<pre>";
       // $payData = '<br/>Telefono Comprador: '.$result['ANSWER']->telephone;
       // $payData .= '<br/>Referencia de Pago: '.$result['ANSWER']->description;
        $payData .= '<br/>Metodo de pago: '.$result['ANSWER']->paymentMethod;
       // $payData .= '<br/>Tipo de pago: '.$result['ANSWER']->lapPaymentMethodType;
        $payData .= '<br/>Valor: '.$result['ANSWER']->additionalValues->TX_VALUE->value;
        $payData .= '<br/>Moneda: '. $result['ANSWER']->additionalValues->TX_VALUE->currency;
        $payData .= '<br/>Estado Actual: '.$result['ANSWER']->transactionResponse->responseCode;

        $result['ANSWER'] = $payData;

        $response->status = "true";

      }else{

        $payData = '<br/>Telefono Comprador: '.$result['ANSWER']->telephone;
        $payData .= '<br/>Referencia de Pago: '.$result['ANSWER']->description;
        $payData .= '<br/>Metodo de pago: '.$result['ANSWER']->lapPaymentMethod;
        $payData .= '<br/>Tipo de pago: '.$result['ANSWER']->lapPaymentMethodType;
        $payData .= '<br/>Valor: '.$result['ANSWER']->TX_VALUE;
        $payData .= '<br/>Moneda: '. $result['ANSWER']->currency;
        $payData .= '<br/>Estado Actual: '.$this->getpolResponseCode($result['ANSWER']->polResponseCode);

        $result['ANSWER'] = $payData;

        $response->status = "true";
      }

      $response->data = $result;
      $response->status_code = 200;

    }else{
      $response->status = "No existe información de pago online";
      $response->status_code = 201;
    }
    return $response;
  }


  /**
  * Funcion que establece los datos que serán enviados a payu
  * @param idPayment identificador del registro de pago
  */
  private function getDataPayment($idPayment){

    $response = new stdClass();

    $variable['idPayment'] = $idPayment;
    $variable['commerce'] = $this->commerce;

    $commerce = $this->getDataCommerce();

    $string_sql = $this->sql->cadena_sql("searchTransaction",$variable);
    $result = $this->miRecursoDB->ejecutarAcceso($string_sql,"busqueda");

    if(is_array($result)){
      $result = $result[0];
    }else{
      $response->status_code = 201;
      return $response;
    }

    $result['APIKEY'] = $commerce->data['APIKEY'];
    $result['MERCHANTID'] = $commerce->data['MERCHANTID'];
    $result['ACCOUNTID'] = $commerce->data['ACCOUNTID'];

    $data = array(
        'merchantId' => $result['MERCHANTID'],
        'accountId' => $result['ACCOUNTID'],
        'description' => $result['DESCRIPTION'],
        'referenceCode' => $result['IDPAYMENT'],
        'amount' => $result['VALUE'],
        'extra1' => $this->commerce,
        'extra2' => 'payu-check-in-v2',
        'tax' => '0',
        'taxReturnBase' => "0", //$taxes['base_price'],
        'shipmentValue' => "0",
        'currency' => $result['CURRENCY'],
        'lng' => "es",
        'signature' => $this->getFirm($result),
        'sourceURL' => $this->rutaURL,
        'responseURL' => $result['RESPONSEURL'],
        'test' => "0",
        'buyerEmail' => $result['EMAILCUSTOMER'],
    );
    foreach ($data as $name => $value) {
      $response->data[$name]=$value;
    }

    $url = $this->getActionUrl();
    $response->url = $url->url;
    $response->status_code = 200;

    return $response;
  }

  private function payuGO($value){
    $response = new stdClass();
    $booking = $this->getDataBooking($value);
    $valueBooking = $booking->data['VALUE']*0.5;
    $create = $this->createPayment($this->commerce,$booking->data['CLIENT'],$valueBooking,'COP',"Reserva ".$booking->data['NAME'],$value);

    if($create->status_code = 200){
      $response->id = $create->id;
      $response->status_code = 200;
      $payment = $this->getDataPayment($response->id);
      $response->url = $payment->url;
      $response->data = $payment->data;
    }else{
      $response->status = "Reservable Invalido";
      $response->status_code = 201;
    }

    return $response;

  }


  private function getFirm($settings) {
    $params = array(
      $settings['APIKEY'],
      $settings['MERCHANTID'],
      $settings['IDPAYMENT'],
      $settings['VALUE'],
      $settings['CURRENCY']
    );
    return md5(implode('~',$params));
  }

  private function getActionUrl() {
    $response= new stdClass();
    $response->url = "https://gateway.payulatam.com/ppp-web-gateway/";
    $response->enviroment = "production";
    return $response;
  }

  private function getDataCommerce() {
    $response= new stdClass();

    $string_sql = $this->sql->cadena_sql("dataCommerce",$this->commerce);
    $result = $this->master_resource->ejecutarAcceso($string_sql,"busqueda");

    if(is_array($result)){
      $response->data = $result[0];
    }else{
      $response->status_code = 201;
    }

    return $response;
  }

  /**
  * Esta funcion es el primer paso, inserta los datos en la tabla de pagos
  * y establece el incio de la transaccion e 0
  */
  private function createPayment($idCommerce,$customer,$value,$currency,$description,$referenceCode){

    $response= new stdClass();
    $variable=compact("idCommerce","customer","value","currency","description","referenceCode");

    $string_sql=$this->sql->cadena_sql("insertTransaction",$variable);
    $result=$this->miRecursoDB->ejecutarAcceso($string_sql,"");

    if($result){
      $response->id=$this->miRecursoDB->ultimo_insertado();
      $response->status_code = 200;
    }else{
      $response->status_code = 201;
    }

    return $response;

  }

  private function getDataBooking($idbooking){
    $response = new stdClass();
    $string_sql = $this->sql->cadena_sql("dataRoomBookingbyID",$idbooking);
    $result = $this->miRecursoDB->ejecutarAcceso($string_sql,"busqueda");
    if($result){
      $response->data = $result[0];
      $response->status_code = 200;
    }else{
      $response->status_code = 201;
    }
    return $response;
  }


  private function orderVerify($value) {
    
    $response = new stdClass();
    
    if(empty($value)){
      $response->status = "Empty Value";
      $response->status_code = 201;
    }else{
      $response->status_code = 202;
    }
    
    require_once 'plugin/payu_sdk/PayU.php';

    Environment::setPaymentsCustomUrl("https://api.payulatam.com/payments-api/4.0/service.cgi");
    Environment::setReportsCustomUrl("https://api.payulatam.com/reports-api/4.0/service.cgi");
    Environment::setSubscriptionsCustomUrl("https://api.payulatam.com/payments-api/rest/v4.3/");

    $commerce = $this->getDataCommerce();

    PayU::$apiKey = $commerce->data['APIKEY']; // apiKey.
    PayU::$apiLogin = $commerce->data['APILOGIN']; // apiLogin.
    PayU::$merchantId = $commerce->data['MERCHANTID']; // Id de Comercio.
    PayU::$language = SupportedLanguages::ES; //Seleccione el idioma.
    PayU::$isTest = true; //Dejarlo True cuando sean pruebas.

    $transaction= new stdClass();

    // Código de referencia de la orden.
    $parameters = array(PayUParameters::REFERENCE_CODE => $value);

    $response_payu = PayUReports::getOrderDetailByReferenceCode($parameters);

    foreach ($response_payu as $order) {
      $order->accountId;
      $order->status;
      $order->referenceCode;
      $order->additionalValues->TX_VALUE->value;
      $order->additionalValues->TX_TAX->value;

      if ($order->buyer) {
        $order->buyer->emailAddress;
        $order->buyer->fullName;
      }

      $transactions=$order->transactions;
      foreach ($transactions as $transaction) {
        $transaction->type;
        $transaction->transactionResponse->state;
        $transaction->transactionResponse->paymentNetworkResponseCode;
        $transaction->transactionResponse->trazabilityCode;
        $transaction->transactionResponse->responseCode;
        if ($transaction->payer) {
          $transaction->payer->fullName;
          $transaction->payer->emailAddress;
        }
      }
    }

    $result = $this->updateDataCommerceByReference($value,$transaction);

    $response->answer = $transaction;
    $response->status_code = 200;
    $response->status = $result->status;
    return $response;
  }

  private function updateDataCommerceByReference($value,$transaction) {

    $data = array();
    $data["reference"] = $value;
    $data["answer"] = (string)json_encode($transaction);
    $responseCode = $transaction->transactionResponse->responseCode;
    $data["status"] = ($responseCode=="APPROVED")?"1":"0";
    $string_sql = $this->sql->cadena_sql("updateDataCommerceByReference",$data);
    $result = $this->miRecursoDB->ejecutarAcceso($string_sql,"");
 
    $response = new stdClass();
    $response->status_code = 200;
    $response->status = "Información actualizada";
    return $response;

  }

  private function getpolResponseCode($cod){

    $polResponseCode=array();
    $polResponseCode['1']="Transacci&oacute;n Aprobada.";
    $polResponseCode['4']="Transacci&oacute;n rechazada por la entidad.";
    $polResponseCode['5']="Transacci&oacute;n declinada por la entidad financiera.";
    $polResponseCode['6']="Fondos insuficientes.";
    $polResponseCode['7']="Tarjeta inv&aacute;lida.";
    $polResponseCode['8']="Es necesario contactar a la entidad.";
    $polResponseCode['9']="Tarjeta vencida.";
    $polResponseCode['10']="Tarjeta restringida.";
    $polResponseCode['12']="Fecha de expiraci&oacute;n o campo seg. Inv&aacute;lidos.";
    $polResponseCode['13']="Repita transacci&oacute;n.";
    $polResponseCode['14']="Transacci&oacute;n inv&aacute;lida.";
    $polResponseCode['15']="Transacci&oacute;n enviada a Validaci&oacute;n Manual.";
    $polResponseCode['17']="Monto excede m&aacute;ximo permitido por entidad.";
    $polResponseCode['22']="Tarjeta no autorizada para realizar compras por internet.";
    $polResponseCode['23']="Transacci&oacute;n Rechazada por el Modulo Antifraude.";
    $polResponseCode['25']="Transacci&oacute;n esta pendiente de aprobacion.";
    $polResponseCode['50']="Transacci&oacute;n Expirada, antes de ser enviada a la red del medio de pago.";
    $polResponseCode['51']="Ocurri&oacute; un error en el procesamiento por parte de la Red del Medio de Pago.";
    $polResponseCode['52']="El medio de Pago no se encuentra Activo. No se env? la solicitud a la red del mismo.";
    $polResponseCode['53 ']="Banco no disponible.";
    $polResponseCode['54']="El proveedor del Medio de Pago notifica que no fue aceptada la transacci&oacute;n.";
    $polResponseCode['55 ']="Error convirtiendo el monto de la transacci&oacute;n.";
    $polResponseCode['56']="Error convirtiendo montos del deposito.";
    $polResponseCode['9994']="Transacci&oacute;n pendiente por confirmar.";
    $polResponseCode['9995']="Certificado digital no encontrado.";
    $polResponseCode['9997']="Error de mensajer? con la entidad financiera.";
    $polResponseCode['10000']="Ajustado Autom&aacute;ticamente.";
    $polResponseCode['10001']="Ajuste Autom&aacute;tico y Reversi&oacute;n Exitosa.";
    $polResponseCode['10002']="Ajuste Autom&aacute;tico y Reversi&oacute;n Fallida.";
    $polResponseCode['10003']="Ajuste autom&aacute;tico no soportado.";
    $polResponseCode['10004']="Error en el Ajuste.";
    $polResponseCode['10005']="Error en el ajuste y reversi&oacute;n.";

    return $polResponseCode[$cod];
  }

}
