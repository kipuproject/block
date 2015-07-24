<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;

}else{

	$cadena_sql=$this->sql->cadena_sql("typeListRoom");
	$typeListRoom=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");


	$cadena_sql=$this->sql->cadena_sql("createRoom",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");

	$variable['idroom']=$this->miRecursoDB->ultimo_insertado();

	/*for($i=1;$i<=3;$i++){
		$variable['season']=$i;
		$cadena_sql=$this->sql->cadena_sql("createPrices",$variable);
		$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
	}*/

	$formSaraData="&pagina=roomsManagement";
	$formSaraData.="&saramodule=host";
	$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraData,$this->enlace);

	echo "<script>location.replace('".$formSaraData."')</script>";
	include_once($this->ruta."/html/newRoom.php");

}
?>
