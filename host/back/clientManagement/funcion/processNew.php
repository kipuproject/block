<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$cadena_sql=$this->sql->cadena_sql("insertData",$_REQUEST);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	$this->mensaje="Datos Insertados Correctamente";
	
	return $this->status=TRUE;	
}
?>
