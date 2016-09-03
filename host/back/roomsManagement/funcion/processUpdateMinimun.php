<?php
if(!isset($GLOBALS["autorizado"])){
	include("index.php");
	exit;
}else{

	$this->mensaje="";

  if(isset($variable['minimun'][$variable['season']])) {
    $variable['min_days'] = $variable['minimun'][$variable['season']];
  }else {
    $variable['min_days'] = 1;
  }
  
	$cadena_sql=$this->sql->cadena_sql("getTypeRoomSeason",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

	//si ya existe actualice
	if(is_array($result)) {
		$cadena_sql=$this->sql->cadena_sql("updateTypeRoomSeason",$variable);
		$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	}else {
	//si no existe inserte
		$cadena_sql=$this->sql->cadena_sql("insertTypeRoomSeason",$variable);
		$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	}
  
  $this->mensaje.="Reserva Minima Actualizada";

	

	return $this->status=FALSE;

}
?>
