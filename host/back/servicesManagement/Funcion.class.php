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

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion

//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionservicesManagement
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

	function action()
	{
			
		//Evitar que se ingrese codigo HTML y PHP en los campos de texto
		//Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir="";
		$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);

		$option=isset($_REQUEST['optionProcess'])?$_REQUEST['optionProcess']:"";
 
		
		switch($option){
			case "processEdit":
				$this->processEdit($_REQUEST);
				echo $this->mensaje;
			break;
			
			case "processDelete":
				$this->processDelete($_REQUEST);
			break;
			case "processUpdateCapacity":
				$this->processUpdateCapacity($_REQUEST);
				echo $this->mensaje;
			break;
			case "processNew":
				$this->processNew($_REQUEST);    
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

		$conexion="aplicativo";
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		
		if(!$this->miRecursoDB){
		
			$this->miConfigurador->fabricaConexiones->setRecursoDB($conexion,"tabla");
			$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);			
		}
		
		
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
