<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
	
}else{
	$error=0;

	if($variable['nameCompany']==""){
		$this->mensaje[] = "el nombre de la empresa es obligatorio";
		$error++;
	}
	
	if($error>0){
	
		return $this->status="FALSE";
		
	}else{	
	
		$cadena_sql=$this->sql->cadena_sql("insertCompany",$variable);
		$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
		
		if(!$this->miRecursoDB){
			
			$this->mensaje[]="Error de Conexion";
			return $this->status="FALSE";
				
		}elseif($this->miRecursoDB->obtener_error()<>""){
			
			$this->mensaje[]="Error de datos: ".$this->miRecursoDB->obtener_error();
			return $this->status="FALSE";
			
		}else{
		
			$this->id=$this->miRecursoDB->ultimo_insertado();
			return $this->status="TRUE";
		}

	}
					
	return $this->status="FALSE";				
}
?>
