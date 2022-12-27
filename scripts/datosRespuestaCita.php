<?php

include '../config.php';
session_start();

//Obtener informacion de la peticion ajax
$codigoAlumno = $_POST["codigoAlumno"];
$fecha = $_POST["fecha"];
$horaInicio = $_POST["horaInicio"];
$respuesta = $_POST["respuesta"];   //Aceptado o Rechazado

echo "El alumno ".$codigoAlumno." con cita pendiente el ".$fecha." a las ".$horaInicio.":00 "." tiene ahora la cita en estado ".$respuesta;
?>