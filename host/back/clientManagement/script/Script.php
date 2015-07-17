<?php

$indice=0;


$embebido[$indice]=true;
$funcion[$indice++]="function.js";
$funcion[$indice++]="datatable/jquery.dataTables.min.js";
$funcion[$indice++]="datatable/TableTools.min.js";
$funcion[$indice++]="datatable/ColReorderWithResize.js";
$funcion[$indice++]="datatable/ColVis.min.js";
$funcion[$indice++]="datatable/jquery.dataTables.columnFilter.js";
$funcion[$indice++]="datatable/jquery.dataTables.grouping.js";
$funcion[$indice++]="datatable/jquery.dataTables.min.js";
$funcion[$indice++]="eakroko.min.js";
$funcion[$indice++]="application.min.js";
$funcion[$indice++]="demonstration.min.js";

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}	


foreach ($funcion as $clave=>$nombre){
	if(!isset($embebido[$clave])){
		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'>\n</script>\n";
	}else{
		echo "\n<script type='text/javascript'>";
		include($nombre);
		echo "\n</script>\n";
	}
}

?>
