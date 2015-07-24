<?php
if(!isset($GLOBALS["autorizado"])){

	include("index.php");
	exit;

}else{

	$this->mensaje="";

	$cadena_sql=$this->sql->cadena_sql("updateDataRoom",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	$this->mensaje.="Habitacion Actualizada";



	return $this->status=FALSE;

}
?>
