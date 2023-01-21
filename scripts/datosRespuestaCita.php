<?php
include '../config.php';
session_start();
//Función para obtener el nombre de día dado una fecha
function getDayName($fechats){
    //$fechats es de tipo timestamp
    switch (date('w', $fechats)){
        case 0: return "Domingo"; break;
        case 1: return "Lunes"; break;
        case 2: return "Martes"; break;
        case 3: return "Miercoles"; break;
        case 4: return "Jueves"; break;
        case 5: return "Viernes"; break;
        case 6: return "Sabado"; break;
    }
}
function getMonthName($fechats){
    //$fechats es de tipo timestamp
    switch (date('n', $fechats)){
        case 1: return "Enero"; break;
        case 2: return "Febrero"; break;
        case 3: return "Marzo"; break;
        case 4: return "Abril"; break;
        case 5: return "Mayo"; break;
        case 6: return "Junio"; break;
        case 7: return "Julio"; break;
        case 8: return "Agosto"; break;
        case 9: return "Setiembre"; break;
        case 10: return "Octubre"; break;
        case 11: return "Noviembre"; break;
        case 12: return "Diciembre"; break;
    }
}
//Obtener informacion de la peticion ajax
$codigoAlumno = $_POST["codigoAlumno"];
$fecha = $_POST["fecha"];
$horaInicio = $_POST["horaInicio"];
$fechaTs = strtotime($fecha);   //Obtener timestap de la fecha de solicitud de tutoría
//Obtener código de tutor
$codigoTutor = $_SESSION["codigo"];
//Obtener día de tutoria
$diaTutoria = getDayName($fechaTs);
//Generar respuesta: si el envío de ajax es "aceptado" a este se asigna "confirmado", caso contrario "rechazado"
$respuesta = strtolower($_POST["respuesta"]) == "aceptado" ? "Confirmado":"Rechazado";   //Aceptado o Rechazado
//-------------------------Actualizar estado en la base de datos-------------------------
//Crear consulta
$consultaActualizacion = "UPDATE cita SET estado = '$respuesta' WHERE codigoAlumno='$codigoAlumno' and horaInicio='$horaInicio' and fecha='$fecha'";
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
            $horaInCitaPendiente = $datosCita["horaInicio"];
            //Actualizar estado
            $consulta = "UPDATE cita Set estado = 'Rechazado' WHERE codigoAlumno = '$codAlumnoCitaPendiente' and horaInicio = '$horaInCitaPendiente' and fecha = '$fechaCitaPendiente'";
            mysqli_query($conexion, $consulta);
        }
    }
    //Marcar hora en el horario del tutor como "ocupado"
    $consultaActualizacionHorarioTutor = "UPDATE disponibilidad Set estado='ocupado' where codigoTutor='$codigoTutor' and dia='$diaTutoria' and horaInicio='$horaInicio'";
    mysqli_query($conexion, $consultaActualizacionHorarioTutor);
}
// Obtener fecha y hora actual 
date_default_timezone_set('America/Lima');
$fechaCreacionNotificacion = date('Y-m-d H:i');    //(numberDay, day, month, year, hour, minute)
//Crear notificación para el alumno 
$diaCita = date("d", $fechaTs) + 1;
$nombreMesCita = getMonthName($fechaTs);
$respuestaNotificacion = $respuesta == "Confirmado" ? "aceptada": "rechazada";
$asuntoNotificacion = $respuesta;
$mensajeNotificacionAlumno = "Tu solicitud de tutoría para el día ".$diaTutoria." ".$diaCita." de ".$nombreMesCita." a las ".$horaInicio." horas fue ".$respuestaNotificacion;
$consultaCrearNotificacionAlumno = "INSERT INTO notificaciones(codigoAlumno, fecha, mensaje, asunto, visto) VALUES('$codigoAlumno', '$fechaCreacionNotificacion', '$mensajeNotificacionAlumno', '$asuntoNotificacion', 'No')";
mysqli_query($conexion, $consultaCrearNotificacionAlumno);
echo $mensajeNotificacionAlumno;
// echo "El alumno ".$codigoAlumno." con cita pendiente el ".$fecha." a las ".$horaInicio.":00 "." tiene ahora la cita en estado ".$respuesta;
?>