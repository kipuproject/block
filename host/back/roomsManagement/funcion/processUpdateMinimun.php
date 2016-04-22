<?php
if(!isset($GLOBALS["autorizado"])){
	include("index.php");
	exit;
}else{

	$this->mensaje="";
	
	$cadena_sql=$this->sql->cadena_sql("updateDataTypeRoom",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	
	$this->mensaje.="Reserva Minima Actualizada";
				
	return $this->status=FALSE;

}
?>