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
      
      //Si no tiene merchanti id no es la primer respuesta recibida
      if(empty($result['ANSWER']->merchantId)){
        echo "NO TIENE";
        var_dump($result['ANSWER']->merchantId);
      }else{
        echo "SI TIENE";
        var_dump($result['ANSWER']->merchantId);
      } 
      //$response->data = $result;
    
      $response->status_code = 200;
    }else{
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
    $response=new stdClass();
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
    
    // Ingresa aquí el código de referencia de la orden.
    $parameters = array(PayUParameters::REFERENCE_CODE => $value);

    $response = PayUReports::getOrderDetailByReferenceCode($parameters);

    foreach ($response as $order) {	
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
    return $transaction; 
  }  
}