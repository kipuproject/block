<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
	
}else{
	$error=0;

	if($variable['nameCommerce']==""){
		$this->mensaje[] = "El nombre del comercio es obligatorio";
		$error++;
	}

	$machine_name=$this->miInspectorHTML->friendly_url($variable['nameCommerce']);
	$variable['files_folder']="files/restaurantes/".$machine_name;
	
	if($error>0){
	
		return $this->status="FALSE";
		
	}else{	
	
		$cadena_sql=$this->sql->cadena_sql("insertCommerce",$variable);
		$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
		
		if(!$this->miRecursoDB){
			
			$this->mensaje[]="Error de Conexion";
			return $this->status="FALSE";
				
		}elseif($this->miRecursoDB->obtener_error()<>""){
			
			$this->mensaje[]="Error de datos: ".$this->miRecursoDB->obtener_error();
			return $this->status="FALSE";
			
		}else{
			$this->mensaje[]="Se ha creado un nuevo comercio correctamente";
			$this->mensaje[]="Ingresa mas informacion en la seccion de configuracion";

			if(!mkdir($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/files/restaurantes/".$machine_name, 0777, true)){
				$this->mensaje[]="no se creo la carpeta de archivos, porfavor creela manualmente ";
			}else{
				mkdir($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/files/restaurantes/".$machine_name."/promociones", 0777, true);
				mkdir($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/files/restaurantes/".$machine_name."/galeria", 0777, true);
			}

			return $this->status="TRUE";
		}

	}
					
	return $this->status="FALSE";				
}
?>
