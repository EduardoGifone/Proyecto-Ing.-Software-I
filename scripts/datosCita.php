<?php

session_start();
//Obtener informacion de la peticion ajax
$horaInicio = $_POST["horaInicio"];
$horaFin = $_POST["horaFin"];
$dia = strtolower($_POST["dia"]);
$codigo = $_POST["codigoAlumno"];
$razon = $_POST["razon"];
$codigoAlumno = $_SESSION["codigo"];
$limite = 5;

//Generar número de día
$days = array(1=>"lunes",2=>"martes",3=>"miercoles",4=>"jueves",5=>"viernes",6=>"sabado",7=>"domingo");
$nroDia = array_search($dia,$days);
//--------------------- Obtener fecha actual ---------------------
//Establecer zona horario (Perú)
date_default_timezone_set('America/Lima');
// Obtener una lista con la fecha actual 
$fechaHoy = date('N-d-m-Y-H-i');    //(numberDay, day, month, year, hour, minute)
$lista = explode('-', $fechaHoy);
$diference = $nroDia - $lista[0];
$var = 1;

//---------------- Validar día seleccionado ----------------
if ($diference < 0){    //El día seleccionado ya pasó
    echo "El día ya pasó";
    $var = 0;
}
else if ($diference == 0){   //El día es hoy
    //Obtener hora actual
    $horaActual = $lista[4];
    //Validar hora
    if($horaInicio - $horaActual < $limite){
        echo "Nope";
        $var = 0;
    }
}
if ($var){
    //-----------------------Enviar reserva a la base de datos-----------------------
    $fecha = date_create();
    date_add($fecha, date_interval_create_from_date_string($diference." days"));
    $newDate = date_format($fecha,"Y-m-d");
    //Conectar con la base de datos
    include '../config.php';
    //Crear consulta
    $consulta = "INSERT INTO cita values('$newDate','$horaInicio','$horaFin','$codigoAlumno','PENDIENTE','$razon',null)";
    //Ejecutar consulta
    if (mysqli_query($conexion, $consulta)){
        echo "Cita reservada ";
    }
    else{
        echo "Error en Mysql";
    } 
}
//Resultado que se enviara mediante la peticion ajax
// $return = "Hola, soy el alumno ".$codigo." y quiero una cita el dia".$dia." de ".$horaInicio." a ".$horaFin." ya que ".$razon;
// echo $return;
?>
