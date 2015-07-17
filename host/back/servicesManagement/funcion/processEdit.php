<?
if(!isset($GLOBALS["autorizado"])){

	include("index.php");
	exit;
	
}else{

	$this->mensaje="";
	 
	$cadena_sql=$this->sql->cadena_sql("updateDataService",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	$this->mensaje.="Servicio Actualizado";
	

	foreach($variable as $key=>$value){
	
		$explode=explode("-",$key);
		
		if($explode[0]=="currency"){
		
			$variable["price"]=$value;
			$variable["currency"]=$explode[1];
			$variable["season"]=$explode[2]; 
			 
			$cadena_sql=$this->sql->cadena_sql("updateDataValueService",$variable);
			$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");			
		}
		
	}
				
	return $this->status=FALSE;

}
?>
