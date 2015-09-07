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
include_once("core/builder/WidgetHtml.class.php");
include_once("core/auth/Sesion.class.php");
 

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion

//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncioncompanyManagement
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
	var $mensaje=array();
	var $status;
	

	function processNewCompany($variable){
		include_once($this->ruta."/funcion/processNewCompany.php");
	}
	
	function processNewCommerce($variable){
		include_once($this->ruta."/funcion/processNewCommerce.php");
	}
	
	function processEdit($option){
		$imgs=new WidgetHtml();
		include_once($this->ruta."/funcion/processEdit.php");
	}

	function processDelete($id){
		include_once($this->ruta."/funcion/processDelete.php");
	}

	function redireccionar($option, $valor=""){
		include_once($this->ruta."/funcion/redireccionar.php");
	}

	function action(){
      //Evitar que se ingrese codigo HTML y PHP en los campos de texto
		//Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir="";
		$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);

		$option=isset($_REQUEST['optionProcess'])?$_REQUEST['optionProcess']:"";

		
		switch($option){
			case "processNewCompany":
				$this->processNewCompany($_REQUEST);
				
				$responce=new stdClass();
				$responce->mensaje = implode("\n",$this->mensaje);
				$responce->status = $this->status;
				$responce->id = $this->id;
				echo json_encode($responce);
				
			break;
			case "processNewCommerce":
				$this->processNewCommerce($_REQUEST);
				echo implode("\n",$this->mensaje);				
			break;			
			
			case "processEditCommerce":
			case "processEditCompany":
				$this->processEdit($option);
				echo $this->mensaje;
			break;
			case "processDelete":
				$this->processDelete($option);
				echo $this->mensaje;
			break;
		}




	}


	function __construct()
	{
		
		$this->miConfigurador=Configurador::singleton();

		$this->miInspectorHTML=InspectorHTML::singleton();
			
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");		
		$this->miMensaje=Mensaje::singleton();
		
		$this->enlace=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."?".$this->miConfigurador->getVariableConfiguracion("enlace");

		$this->miSesion=Sesion::singleton();
		$conexion=$this->miSesion->getValorSesion('dbms');
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);		
		$this->idSesion=$this->miSesion->getValorSesion('idUsuario');
		$this->commerce=$this->miSesion->getValorSesion('commerce');
		$this->masterResource=$this->miConfigurador->fabricaConexiones->getRecursoDB("master");		

		
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
		//Incluir las funciones
	}

	function setSql($a)
	{
		$this->sql=$a;
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
