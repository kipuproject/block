<?php
$token=strrev(($this->miConfigurador->getVariableConfiguracion("enlace")));
$this->idioma[$token."usuario"]="Usuario:";
$this->idioma[$token."clave"]="Clave:";
$this->idioma["enlaceRecordarClave"]="¿Olvidó su clave?";
$this->idioma["loginButton"]="Ingresar";
$this->idioma["botonAceptar"]="Aceptar";
$this->idioma["numeroPersonas"]="Guess";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma["botonReservar"]="Book Now";
$this->idioma["botonBuscar"]="Search";
$this->idioma["botonContinuar"]="Next";
$this->idioma["mensajeDisponibilidad"]="My Booking";
$this->idioma["mensajeReservables"]="Available locations";
$this->idioma["mensajeAdicionales"]="Other services";
$this->idioma["fechaInicio"]="Check-in Date";
$this->idioma["fechaFin"]="Check-out Date";
$this->idioma["mensajeDetallesContacto"]="Contact Details"; 
$this->idioma[$token."checkbox"]="Recordarme";
$this->idioma["noDefinido"]="No definido";
$this->idioma["encabezadoBarra"]="RESERVAME - Ecuador";

?>
