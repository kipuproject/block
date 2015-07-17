	<?
include_once("core/manager/Configurador.class.php");
include_once("core/auth/Sesion.class.php");
include_once("plugin/filter/generadorFiltros.class.php");

class FronteraservicesManagement{

	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $formulario;
	var $enlace;
	var $miConfigurador;
	var $companies;
	
	function __construct()
	{
	
		$this->miConfigurador=Configurador::singleton();
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB("aplicativo");
		$this->enlace=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."?".$this->miConfigurador->getVariableConfiguracion("enlace");
		$this->miSesion=Sesion::singleton();
		$this->idSesion=$this->miSesion->getValorSesion('idUsuario');
		if($this->idSesion==""){
			echo "Sesion cerrada<br/>";
		}
		
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

	function setSql($a)
	{
		$this->sql=$a;

	}

	function setFuncion($funcion){
		$this->funcion=$funcion;

	}

	



	function html(){
		
		include_once("core/builder/FormularioHtml.class.php");
		
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

		$this->miFormulario=new formularioHtml();

		$option=isset($_REQUEST['option'])?$_REQUEST['option']:"list";


		switch($option){
			case "list":
				$this->showList();
				break;				
			case "new":
				$this->showNew();
				break;
			case "edit":
				$this->showEdit($_REQUEST['optionValue']);
				break;
			case "view":
				$this->showEdit($_REQUEST['optionValue']);
				break;

		}
		
	}
	


	function showListRooms($commerce="1",$currency="COP"){
	
		$variable["commerce"]=$commerce;//Le envio 1 provisionalmente asumiendo q el sistema solo esta funcionando para un comercio
		$variable["currency"]=$currency;//Le envio COP por defecto mientras se paramtriza

		$cadena_sql=$this->sql->cadena_sql("serviceListbyCommerce",$variable);
		$serviceList=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		$cadena_sql=$this->sql->cadena_sql("priceList");
		$priceList=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		$cadena_sql=$this->sql->cadena_sql("typeListRoom");
		$typeListRoom=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		$priceList=$this->orderArrayKeyBy($priceList,"IDRESERVABLE","SEASON");
		
		$formSaraData="jxajax=main";
		$formSaraData.="&action=servicesManagement";
		$formSaraData.="&bloque=servicesManagement";
		$formSaraData.="&idcommerce=".$commerce;
	   	$formSaraData.="&bloqueGrupo=host/back";
		
		$formSaraDataEdit=$formSaraData."&optionProcess=processEdit";
		$formSaraDataEdit=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataEdit,$this->enlace);

		$formSaraDataNew.="action=servicesManagement";
		$formSaraDataNew.="&bloque=servicesManagement";
		$formSaraDataNew.="&idcommerce=".$commerce;
	   	$formSaraDataNew.="&bloqueGrupo=host/back";
		$formSaraDataNew.="&optionProcess=processNew";
		$formSaraDataNew=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataNew,$this->enlace);
		
		$formSaraDataTypeRooms.="pagina=servicesManagement";
		$formSaraDataTypeRooms.="&bloque=servicesManagement";
		$formSaraDataTypeRooms.="&idcommerce=".$commerce;
	   	$formSaraDataTypeRooms.="&bloqueGrupo=host/back";
		$formSaraDataTypeRooms.="&option=listTypeRooms";
		$formSaraDataTypeRooms.="&tema=admin";
		$formSaraDataTypeRooms=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataTypeRooms,$this->enlace);
		
		$formSaraDataDelete.="action=servicesManagement";
		$formSaraDataDelete.="&bloque=servicesManagement";
		$formSaraDataDelete.="&idcommerce=".$commerce;
	   	$formSaraDataDelete.="&bloqueGrupo=host/back";
		$formSaraDataDelete.="&optionProcess=processDelete";
		$formSaraDataDelete=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataDelete,$this->enlace);
				
		include_once($this->ruta."/html/listRooms.php");
	}	
	
	
	function showList($commerce="1",$currency="COP"){
	
		$variable["commerce"]=$commerce;//Le envio 1 provisionalmente asumiendo q el sistema solo esta funcionando para un comercio
		$variable["currency"]=$currency;//Le envio COP por defecto mientras se paramtriza

		$cadena_sql=$this->sql->cadena_sql("serviceListbyCommerce",$variable);
		$serviceList=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		  
		$cadena_sql=$this->sql->cadena_sql("priceList");
		$priceList=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		$priceList=$this->orderArrayKeyBy($priceList,"IDSERVICE","SEASON");
		 
		 
		$formSaraData="jxajax=main";
		$formSaraData.="&action=servicesManagement";
		$formSaraData.="&bloque=servicesManagement";
		$formSaraData.="&idcommerce=".$commerce;
	   	$formSaraData.="&bloqueGrupo=host/back";
		
		$formSaraDataEdit=$formSaraData."&optionProcess=processEdit"; 
		$formSaraDataEdit=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataEdit,$this->enlace);
		
				
		$formSaraDataCapacity=$formSaraData."&optionProcess=processUpdateCapacity";
		$formSaraDataCapacity=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataCapacity,$this->enlace);
		
		
		
		$formSaraDataNew.="action=servicesManagement";
		$formSaraDataNew.="&bloque=servicesManagement";
		$formSaraDataNew.="&idcommerce=".$commerce;
	   	$formSaraDataNew.="&bloqueGrupo=host/back";
		$formSaraDataNew.="&optionProcess=processNew";  
		$formSaraDataNew=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataNew,$this->enlace);
		
		$formSaraDataRooms.="pagina=servicesManagement";
		$formSaraDataRooms.="&bloque=servicesManagement";
		$formSaraDataRooms.="&idcommerce=".$commerce;
	   	$formSaraDataRooms.="&bloqueGrupo=host/back";
		$formSaraDataRooms.="&option=listRooms";
		$formSaraDataRooms.="&tema=admin";
		$formSaraDataRooms=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataRooms,$this->enlace);
		
		$formSaraDataDelete.="action=servicesManagement";
		$formSaraDataDelete.="&bloque=servicesManagement";
		$formSaraDataDelete.="&idcommerce=".$commerce;
	   	$formSaraDataDelete.="&bloqueGrupo=host/back";
		$formSaraDataDelete.="&optionProcess=processDelete";
		$formSaraDataDelete=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraDataDelete,$this->enlace);
				
		include_once($this->ruta."/html/list.php"); 
	}
	

	function showNew(){

		$cadena_sql=$this->sql->cadena_sql("companyList");
		$companyList=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

		$cadena_sql=$this->sql->cadena_sql("roleList");
		$roleList=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

		$formSaraData="bloque=userManagement";
		$formSaraData.="&bloqueGrupo=admin";
		$formSaraData.="&action=userManagement";
		$formSaraData.="&option=processNew";
		$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar($formSaraData);

		include_once($this->ruta."/html/new.php");
	}


	function orderArrayKeyBy($array,$key,$second_key,$third_key=""){

		$newArray=array();

		if($third_key<>""){
		
			foreach($array as $name=>$value){
				$newArray[$value[$key]][$value[$second_key]][$value[$third_key]]=$array[$name];
			}
			
		}else{
		
			foreach($array as $name=>$value){
				$newArray[$value[$key]][$value[$second_key]]=$array[$name];
			}
			
		}	
		/*echo "<pre>";
		var_dump($newArray);
		echo "</pre>";*/
		return $newArray;
	}






}
?>
