<?php

include '../config.php';
session_start();

// Obtener el codigo del tutor
$tutor_id = $_SESSION['codigo'];

//Obtener informacion de la peticion ajax
$disponibilidades = $_POST["disponibilidades"];

//Realizar la conexion a la bd y la consulta INSERT
$conexion = mysqli_connect("localhost", "root","","dbtutorias", 3307);
for($i = 0; $i < count($disponibilidades); $i++){
    $dia = $disponibilidades[$i][0];
    $Hini = $disponibilidades[$i][1];
    $Hfin = $disponibilidades[$i][2];
    $consult = "INSERT INTO disponibilidad(codigoTutor, dia, horaInicio, horaFin) values('$tutor_id','$dia',$Hini,$Hfin)";

    if(mysqli_query($conexion, $consult)){
        echo '<h1>Datos ingresados</h1>';
    }
    else{
        echo '<h1>Datos no ingresados</h1>';
    }
}

//Resultado que se enviara mediante la peticion ajax
$return = 0;
echo $return;
?>