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

class Funcionmaster
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
	

	function processNew(){
		include_once($this->ruta."/funcion/processNew.php");
	}

	function processEdit($id){
		include_once($this->ruta."/funcion/processEdit.php");
	}

	function processDelete($id){
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

		$option=isset($_REQUEST['option'])?$_REQUEST['option']:"updatecommerce";
		
		
		switch($option){
		
			case "updatecommerce":
				//validar permiso
				$variable['user']=$this->miSesion->getValorSesion('idUsuario');
				$variable['commerce']=$_REQUEST['commerce'];
				$variable['currentType']=$_REQUEST['currentType'];
				
				$cadena_sql=$this->sql->cadena_sql("dataCommerce",$variable);
				$dataCommerce=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
				 
				$this->miSesion->guardarValorSesion('dbms',$dataCommerce[0]['DBMS']); 
				$this->miSesion->guardarValorSesion('commerce',$dataCommerce[0]['IDCOMMERCE']);
				$this->miSesion->guardarValorSesion('typecommerce',$variable['currentType']);
				
				$formSaraData="pagina=".$_REQUEST['currentPage'];
				$formSaraData.="&saramodule=".$_REQUEST['currentModule'];
				$formSaraData.="&typecommerce=".$_REQUEST['currentType'];
				$formSaraData.="&commerce=".$_REQUEST['commerce'];
				$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraData,$this->enlace); 
				
				echo "<script>location.replace('$formSaraData')</script>";

				
			break;
			case "updateType":
			
				$formSaraData="pagina=".$_REQUEST['currentPage'];
				$formSaraData.="&saramodule=".$_REQUEST['currentModule'];
				$formSaraData.="&typecommerce=".$_REQUEST['typecommerce'];
				$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraData,$this->enlace); 
				
				$this->miSesion->borrarValorSesion("dbms");
		
				echo "<script>location.replace('$formSaraData')</script>";

			
			break;
			
		}




	}


	function __construct(){
		
		$this->miConfigurador=Configurador::singleton();
		$this->miInspectorHTML=InspectorHTML::singleton();
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");		
		$this->miMensaje=Mensaje::singleton();
		$conexion="master";
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		$this->miSesion=Sesion::singleton();
		$this->enlace=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."?".$this->miConfigurador->getVariableConfiguracion("enlace");
		
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
