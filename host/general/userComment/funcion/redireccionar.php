<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{

		case "reservaExitosa":
			$variable="pagina=index";
			$variable.="&tema=default";
			$variable.="&mensaje=".$valor;
			break;
		
		case "mostrarDisponibilidadIR":
			$variable="pagina=index";
			$variable.="&tema=default";
			$variable.="&option=nuevaReserva_metodo_IR";
			$variable.="&mensaje=".$valor[0];
			foreach($valor[1] as $clave=>$contenido){
				$variable.="&".$clave."=".$contenido;
			}	
			break;
		case "mostrarDisponibilidadNP":
			$variable="pagina=index";
			$variable.="&tema=default";
			$variable.="&option=nuevaReserva_metodo_NP";
			$variable.="&mensaje=".$valor[0];
			foreach($valor[1] as $clave=>$contenido){
				$variable.="&".$clave."=".$contenido;
			}	
			break;
			
		case "mostrarTiposReserva":
			$variable="pagina=index";
			$variable.="&tema=default";
			$variable.="&option=mostrarTiposReserva";
			$variable.="&mensaje=".$valor[0];
			foreach($valor[1] as $clave=>$contenido){
				$variable.="&".$clave."=".$contenido;
			}	
			break;

		case "paginaPrincipal":
			$variable="pagina=index";
			$variable.="&usuario=".$valor;
			$variable.="&mensaje=falloRegistro";
			break;


	}

	foreach($_REQUEST as $clave=>$valor)
	{
		unset($_REQUEST[$clave]);

	}

	$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
	$variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

	$_REQUEST[$enlace]=$variable;
	$_REQUEST["recargar"]=true;

}

?>
