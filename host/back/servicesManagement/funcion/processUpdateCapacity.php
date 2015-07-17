<?
if(!isset($GLOBALS["autorizado"])){

	include("index.php");
	exit;
	
}else{

	$this->mensaje="";
	
	$cadena_sql=$this->sql->cadena_sql("updateDataTypeRoom",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	
	
	
	//busco los q tienen precios de invitados mayor a la capacidad actual
	//y los elmino
	
	$cadena_sql=$this->sql->cadena_sql("deletePricesOverCapacity",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	
	
	//busco si existe la capacidad si no la inserto con 0 pesos
	
	$guest=1;
	
	for($guest;$guest<=$variable['capacity'];$guest++){

		$variable['guest']=$guest;
		$cadena_sql=$this->sql->cadena_sql("priceListbyGuest",$variable);
		$priceListbyGuest=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		if(!is_array($priceListbyGuest)){
		
			for($i=1;$i<=4;$i++){
				$variable['season']=$i;
				$cadena_sql=$this->sql->cadena_sql("createPrices",$variable);
				$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");		
			}
		
		}
	
	}
	
	
	$this->mensaje.="Capacidad Actualizada";
				
	return $this->status=FALSE;

}
?>