<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlNavigation extends sql {
	
	
	var $miConfigurador;
	
	
	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}
	

	function cadena_sql($tipo,$variable="") {
		 
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */
		
		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
		 
		switch($tipo) {
			 
			

			case "roleList":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_subsistema ID, ";
				$cadena_sql.="nombre ROL ";
				$cadena_sql.="FROM "; 
				$cadena_sql.=$prefijo."role ";
				break;

			case "menuList":
				$cadena_sql="SELECT ";
				$cadena_sql.="m.nombre NOMBRE, ";
				$cadena_sql.="m.padre PADRE, ";
				$cadena_sql.="m.rol ROL, ";
				$cadena_sql.="m.tema TEMA, ";
				$cadena_sql.="m.lenguaje IDIOMA, ";
				$cadena_sql.="m.parametro PARAMETRO, ";
				$cadena_sql.="m.icono ICONO, ";
				$cadena_sql.="m.pagina PAGINA, ";
				$cadena_sql.="m.id_menu IDMENU ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."menu m "; 
				$cadena_sql.="WHERE ";
				$cadena_sql.="m.rol ='".$variable."' ";
				break;


		}

		return $cadena_sql;

	}
}
?>
