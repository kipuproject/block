<?php
if(!isset($GLOBALS["autorizado"])){
	include("../index.php");
	exit;
}

class ControlgestionReserva{

	public function action(){
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
	}

	public function setSql($a){
		$this->sql=$a;
	}

	public function setControl($funcion){
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

}
?>
