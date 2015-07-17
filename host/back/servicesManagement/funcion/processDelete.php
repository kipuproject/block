<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$cadena_sql=$this->sql->cadena_sql("deleteService",$variable);
	$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");

	$formSaraData="pagina=servicesManagement";
	$formSaraData.="&option=list";
	$formSaraData=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($formSaraData,$this->enlace);
	
	echo "<script>location.replace('".$formSaraData."')</script>";

}
?>
