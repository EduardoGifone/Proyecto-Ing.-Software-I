<?php

include '../config.php';
session_start();

//Obtener informacion de la peticion ajax
$codigoAlumno = $_POST["codigoAlumno"];
$fecha = $_POST["fecha"];
$horaInicio = $_POST["horaInicio"];
//Generar respuesta: si el envío de ajax es "aceptado" a este se asigna "confirmado", caso contrario "rechazado"
$respuesta = strtolower($_POST["respuesta"]) == "aceptado" ? "Confirmado":"Rechazado";   //Aceptado o Rechazado

//-------------------------Actualizar estado en la base de datos-------------------------
//Crear consulta
$consultaActualizacion = "UPDATE cita SET estado = '$respuesta' WHERE codigoAlumno='$codigoAlumno' and fecha='$fecha'";
//Ejecutar consulta
mysqli_query($conexion, $consultaActualizacion);
//Actualizar solicitudes de citas existentes para la misma hora en caso de que la cita haya sido aceptada
if (strtolower($respuesta) == "confirmado"){
    //Obtener solicitudes de citas para la misma hora de inicio y con estado = pendiente
    $consultaCitas = "SELECT * FROM cita where fecha='$fecha' and horaInicio='$horaInicio' and estado = 'Pendiente'";
    $resultadoConsultaCitas = mysqli_query($conexion, $consultaCitas);
    $citasPendientes = mysqli_num_rows($resultadoConsultaCitas);
    //Actualizar cada cita pendiente obtenida
    if ($citasPendientes){
        while($datosCita = mysqli_fetch_assoc($resultadoConsultaCitas)){
            //Obtener clave primaria
            $codAlumnoCitaPendiente = $datosCita["codigoAlumno"];
            $fechaCitaPendiente = $datosCita["fecha"];
            //Actualizar estado
            $consulta = "UPDATE cita Set estado = 'Rechazado' WHERE codigoAlumno = '$codAlumnoCitaPendiente' and fecha = '$fechaCitaPendiente'";
            mysqli_query($conexion, $consulta);
        }
    }
}
// echo "El alumno ".$codigoAlumno." con cita pendiente el ".$fecha." a las ".$horaInicio.":00 "." tiene ahora la cita en estado ".$respuesta;
?>