<?php

$indice=0;


$embebido[$indice]=true;

$funcion[$indice++]="raphael-min.js";
$funcion[$indice++]="morris.min.js";
$funcion[$indice++]="prettify.min.js";
$funcion[$indice++]="jquery.columns-1.0.min.js";
$funcion[$indice++]="responsivemobilemenu.js";
$funcion[$indice++]="function.js";


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
