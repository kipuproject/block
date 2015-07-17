<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	if(!empty($_REQUEST)){
		$cadena_sql=$this->sql->cadena_sql("DeleteData",$id);
		$result=$this->miRecursoDB->ejecutarAcceso($cadena_sql,"");
		/*if($result){
			echo "true";
		}else{
			echo "false";
		}*/
	}
	
}
?>
