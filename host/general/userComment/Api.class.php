<?php
if(!isset($GLOBALS["autorizado"])){
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Acceso.class.php");

class ApiuserComment{

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
	var $status="";

	function __construct(){
		$this->miConfigurador=Configurador::singleton();
		$this->miInspectorHTML=InspectorHTML::singleton();
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
    $this->rutaURL=$this->miConfigurador->getVariableConfiguracion("host");
		$this->rutaURL.=$this->miConfigurador->getVariableConfiguracion("site");
	  $this->Access=Acceso::singleton();
	  $conexion="master";
	  $this->master_resource=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
	}

	public function setSql($a){
		$this->sql=$a;
	}

	public function setFuncion($funcion){
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}
	
	public function process(){
	
		if(!isset($_REQUEST['key'])){
			echo "error";
			exit;
		}else{ 
			$cadena_sql=$this->sql->cadena_sql("api_key",$_REQUEST['key']);
			$commerce=$this->master_resource->ejecutarAcceso($cadena_sql,"busqueda");
			$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($commerce[0]['DBMS']);
			$this->commerce=$commerce[0]['IDCOMMERCE'];   
			$this->commerce_folder=$commerce[0]['FOLDER']; 
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
				case 'saveComment': 
					$result=$this->saveComment($_REQUEST);
				break;
				case 'getComments': 
					$result=$this->getComments($_REQUEST);  
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
	
	
	private function saveComment($variable){
		
		$response = new stdClass();
    
    $variable['today'] = strtotime("today 00:00");  
    
		$variable['commerce'] = $this->commerce;
		$variable['ip'] = $this->get_client_ip();
    
    $cadena_sql = $this->sql->cadena_sql("getIP",$variable);
		$result = $this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

    if($result[0][0] <= 10){
      $cadena_sql = $this->sql->cadena_sql("insertComment",$variable);
      $result = $this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
      
      if($result){
      
        $response->status_code = 200;  
        $response->status = "true";
        $response->message = "Gracias por tu comentario!";
        
        return $response;
      }  
    
		}else{
    
      $response->status_code = 201;  
      $response->status = "false"; 
      $response->message = "Gracias por todos tus comentarios!";
      
      return $response;
    }
  
		return $response;
		
	}
  
	private function getComments($variable){
  
    $response = new stdClass(); 
    
		$variable['commerce'] = $this->commerce;
		$variable['ip'] = $this->get_client_ip(); 
    
    $cadena_sql = $this->sql->cadena_sql("getComments",$variable);
		$result = $this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
    
    $i=0;
    while(isset($result[$i]['comment'])){
      
      unset($result[$i][0]);
      unset($result[$i][1]);
      unset($result[$i][2]);
      
      $rating[$result[$i]['rating']][] = count($rating[$result[$i]['rating']]);
      
      if($result[$i]['comment'] == ""){
        unset($result[$i]);
      }
      
      $i++;
    }
    
    foreach($rating as $key=>$value){
      $rating_result["s_".$key] = count($value);
    }
    

    $response->comments=array_slice($result, 0, $variable['size']); 
    $response->rating=$rating_result;
    $response->status="true";
    
    return $response;
  }
  
  
  private function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
}