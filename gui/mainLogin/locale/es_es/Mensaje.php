<?php
$token=strrev(($this->miConfigurador->getVariableConfiguracion("enlace")));
$this->idioma[$token."usuario"]="Email:";
$this->idioma[$token."clave"]="Clave:";
$this->idioma["enlaceRecordarClave"]="¿Olvidó su clave?";
$this->idioma["loginButton"]="REGISTRO/LOGIN";
$this->idioma["registerButton"]="Registrate";
$this->idioma["botonAceptar"]="Aceptar";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma[$token."checkbox"]="Recordarme";
$this->idioma["noDefinido"]="No definido";
?>