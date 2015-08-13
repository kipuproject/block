<?php
if(!isset($GLOBALS["autorizado"])){
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");

class FuncionservicesManagement{

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
	

	function processNew($variable){
		include_once($this->ruta."/funcion/processNew.php");
	}
  
	function processUpdateCapacity($variable){
		include_once($this->ruta."/funcion/processUpdateCapacity.php");
	}
	
	function processEdit($variable){
		include_once($this->ruta."/funcion/processEdit.php");
	}
	
	function processDelete($variable){ 
		include_once($this->ruta."/funcion/processDelete.php");
	}

	function redireccionar($option, $valor=""){
		include_once($this->ruta."/funcion/redireccionar.php");
	}

	function action(){
			
		//Evitar que se ingrese codigo HTML y PHP en los campos de texto

		$_REQUEST = $this->miInspectorHTML->limpiarPHPHTML($_REQUEST);
		$option = isset($_REQUEST['optionProcess'])?$_REQUEST['optionProcess']:"";
 
		switch($option){
			case "processEdit":
				$this->processEdit($_REQUEST);
				echo $this->mensaje;
			break;
			case "processDelete":
				$this->processDelete($_REQUEST);
			break;
			case "processNew":
				$this->processNew($_REQUEST);    
			break;
			
		}
	}

	function __construct(){
		$this->miConfigurador=Configurador::singleton();
		$this->miSesion=Sesion::singleton();
    $this->miInspectorHTML=InspectorHTML::singleton();
    $this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
		$conexion=$this->miSesion->getValorSesion('dbms');
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);		
		$this->masterResource=$this->miConfigurador->fabricaConexiones->getRecursoDB("master");		
		$this->commerce=$this->miSesion->getValorSesion('commerce');
		$this->enlace=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."?".$this->miConfigurador->getVariableConfiguracion("enlace");
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
		//Incluir las funciones
	}

	function setSql($a){
		$this->sql=$a;
	}

	function setFuncion($funcion){
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

}
?>
