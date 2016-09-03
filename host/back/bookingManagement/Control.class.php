<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");
include_once("core/auth/Sesion.class.php");


//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion

//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionbookingManagement
{

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
	var $status;


	function action()
	{

		//Evitar que se ingrese codigo HTML y PHP en los campos de texto
		//Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir="";
		$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);

		$option=isset($_REQUEST['optionBooking'])?$_REQUEST['optionBooking']:"";

		switch($option){
			case "voucher":
				$this->showVoucher($_REQUEST['idbooking']);
				break;
			case "addService":
				$this->addService($_REQUEST);
				break;
			case "allReport":
				$this->allReport($_REQUEST);
				break;

		}

	}


	function __construct()
	{

		$this->miConfigurador=Configurador::singleton();
		$this->miInspectorHTML=InspectorHTML::singleton();
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
		$this->rutaURL=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
		$this->miMensaje=Mensaje::singleton();
		$this->miSesion=Sesion::singleton();
		$conexion=$this->miSesion->getValorSesion('dbms');
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		$this->masterResource=$this->miConfigurador->fabricaConexiones->getRecursoDB("master");
		$this->commerce=$this->miSesion->getValorSesion('commerce');

	}

	function showVoucher($booking){

		$variable['IDBOOKING'] = $booking;
		$variable['COMMERCE'] = $this->commerce;

    $cadena_sql=$this->sql->cadena_sql("commerceByID",$this->commerce);
		$commerce = $this->masterResource->ejecutarAcceso($cadena_sql,"busqueda");
		$commerce = $commerce[0];

		$cadena_sql = $this->sql->cadena_sql("detailBooking",$variable);
		$booking = $this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		$booking = $booking[0];

		//$avalaibleRooms=$this->getAvalaibleRooms($booking['ROOM'],strtotime($booking['FECHA_INICIO']),strtotime($booking['FECHA_FIN']),$booking['IDCOMMERCE'],$booking['ROOMTYPE']);
		$this->html->sql=$this->sql;
		$payuPayment=$this->html->getPayuPayment($booking['IDBOOKING']);

		$cadena_sql=$this->sql->cadena_sql("typeRooms",$variable);
		$typeRooms=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		$typeRooms=$this->html->orderArrayKeyBy($typeRooms,"IDTYPEROOM");

		$cadena_sql = $this->sql->cadena_sql("allUsers","");
		$users = $this->masterResource->ejecutarAcceso($cadena_sql,"busqueda");
		$users = $this->html->orderArrayKeyBy($users,"IDUUSER");

		$booking['DNI']=$users[$booking['CLIENT']][0]['DNI'];
		$booking['NAMECLIENT']=$users[$booking['CLIENT']][0]['NAMECLIENT'];
		$booking['COUNTRY']=$users[$booking['CLIENT']][0]['COUNTRY'];
		$booking['EMAILCLIENT']=$users[$booking['CLIENT']][0]['EMAILCLIENT'];
		$booking['PHONECLIENT']=$users[$booking['CLIENT']][0]['PHONECLIENT'];


		$nombrehotel=$this->miConfigurador->getVariableConfiguracion("nombreAplicativo");
		$reference=$booking['IDBOOKING'];
		$logo = $this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."/".$commerce['FOLDER']."/".$commerce['LOGO'];


		$checkin=date("d/m/Y",strtotime($booking['FECHA_INICIO']));
		$chekcout=date("d/m/Y",strtotime($booking['FECHA_FIN']));
		$vallornoche=round(($booking['VALUEBOOKING'])/(round((($booking['FECHA_FIN_UNIX'])*1-($booking['FECHA_INICIO_UNIX'])*1)/86400)));
		$fecha=date("d/m/Y",time());
		$numnoches=round((($booking['FECHA_FIN_UNIX'])*1-($booking['FECHA_INICIO_UNIX'])*1)/86400);
		$numacom=$booking['NUMGUEST'];


		include_once($this->ruta."/html/voucherhtml/voucher.php");

	}


	public function allReport($variable){

		$cadena_sql = $this->sql->cadena_sql("allBookingsByCommerce",$this->commerce);
		$bookings = $this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
    

		$cadena_sql = $this->sql->cadena_sql("allPaymentsByCommerce",$this->commerce);
		$payments = $this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
    $payments = $this->orderArrayKeyBy($payments,"IDBOOKING");

		$cadena_sql = $this->sql->cadena_sql("allUsers","");
		$users=$this->masterResource->ejecutarAcceso($cadena_sql,"busqueda");
		$users=$this->orderArrayKeyBy($users,"IDUUSER");

    $statusBoooking["2"] = "CONFIRMADA";
    $statusBoooking["3"] = "CANCELADA";
    $statusBoooking["6"] = "PENDIENTE";
    
    include_once($this->ruta."/html/allReport.php");
  }

	public function addService($variable){

		switch($variable['opSave']){

			case "add":
				if(!is_numeric($variable['cs']) || !is_numeric($variable['vs'])){
					echo "Ingresa solo numeros, evita puntos, comas u otros caracteres especiales";
					return false;
				}
				$cadena_sql=$this->sql->cadena_sql("searchService",$variable);
				$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
				if(is_array($result)){
					echo "Ya insertaste este servicio, solo tienes que modificar los valores anteriores";
					return false;
				}

				$cadena_sql=$this->sql->cadena_sql("insertServices",$variable);
				$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
				if($result){
					echo "true";
				}else{
					echo "Ups! Hubo un error insertando el servicio";
				}
			break;
			case "update":
				if(!is_numeric($variable['cs']) || !is_numeric($variable['vs'])){
					echo "Ingresa solo numeros, evita puntos, comas u otros caracteres especiales";
					return false;
				}
				$cadena_sql=$this->sql->cadena_sql("updateServices",$variable);
				$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
				if($result){
					echo "true";
				}else{
					echo "Ups! Hubo un error actualizando el servicio";
				}
			break;

			case "delete":
				$cadena_sql=$this->sql->cadena_sql("deleteService",$variable);
				$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
				if($result){
					echo "true";
				}else{
					echo "Ups! Hubo un error eliminando el servicio";
				}
			break;
		}
	}

	function orderArrayKeyBy($array,$key){

		$newArray=array();

		foreach($array as $name=>$value){
			$newArray[$value[$key]][] = $array[$name];
		}
		/*echo "<pre>";
		var_dump($key);
		echo "</pre>";*/
		return $newArray;
	}
  
	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
		//Incluir las funciones
	}

	function setSql($a)
	{
		$this->sql=$a;
	}

	function setHTML($a)
	{
		$this->html=$a;
	}

	function setFuncion($funcion)
	{
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje)
	{
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

}
?>
