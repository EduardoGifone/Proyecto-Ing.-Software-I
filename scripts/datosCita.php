<?php

include '../config.php';
session_start();

//Obtener informacion de la peticion ajax
$horaInicio = $_POST["horaInicio"];
$horaFin = $_POST["horaFin"];
$dia = $_POST["dia"];
$codigo = $_POST["codigoAlumno"];
$razon = $_POST["razon"];

//Resultado que se enviara mediante la peticion ajax
$return = "Hola, soy el alumno ".$codigo." y quiero una cita el dia".$dia." de ".$horaInicio." a ".$horaFin." ya que ".$razon;
echo $return;
?>
