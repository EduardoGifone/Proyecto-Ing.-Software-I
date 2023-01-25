<?php 
//Conexión con la base de datos
include "../config.php";
//Función para obtener el nombre del día dado una fecha
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
//Función para obtener el nombre del mes dado una fecha
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
//Recibir datos pasados desde el frontend
$codigoAlumno =$_POST["codigoAlumno"]; 
$fechaCita =$_POST["fecha"];
$horaIn =$_POST["horaInicio"];
$estadoFinalCita =$_POST["estadoFinal"];    //Finalizado, NP o Postergado
$observacion = $_POST["observacion"];       
//Obtener datos adicionales
session_start();
$codigoTutor = $_SESSION["codigo"];
$fechaStr = strtotime($fechaCita);
$diaCita = getDayName($fechaStr);
//Acomodar estado final
$estadoFinalCita = strtolower($estadoFinalCita) == "finalizado" ? "Realizado": $estadoFinalCita;
//Crear consulta para actualizar estado de cita
$consultaActualizarEstadoCita = "UPDATE cita SET estado='$estadoFinalCita', observacion='$observacion' WHERE fecha='$fechaCita' AND horaInicio='$horaIn' AND codigoAlumno='$codigoAlumno'";
//Ejecutar consulta
mysqli_query($conexion, $consultaActualizarEstadoCita);

//-------------------Actualizar horario de disponibilidad del tutor-------------------
//Crear consulta para actualizar disponibilidad
$consultaActualizarDisponibilidad = "UPDATE disponibilidad SET estado='libre' WHERE dia='$diaCita' AND codigoTutor='$codigoTutor' AND horaInicio='$horaIn'";
//Ejecutar consulta para actualizar disponibilidad
mysqli_query($conexion, $consultaActualizarDisponibilidad);
echo "Cita de fecha ".$diaCita." ".$fechaCita." actualizada a ".$estadoFinalCita."  con observación  ".$observacion;
//----------Notificar al alumno en caso su cita haya sido postergada o clasificada como NP----------
// Obtener fecha y hora actual 
date_default_timezone_set('America/Lima');
$fechaCreacionNotificacion = date('Y-m-d H:i');    //(numberDay, day, month, year, hour, minute)
//Crear notificación para el alumno 
$nroDiaCita = date("d", $fechaStr) + 1;
$nombreMesCita = getMonthName($fechaStr);

if(strtolower($estadoFinalCita) == "np"){
    //Crear mensaje de notificación para el caso NP
    $mensajeNotificacionNP = "No te presentaste a tu cita programada para el ".$diaCita." ".$nroDiaCita." de ".$nombreMesCita;
    //Crear consulta para insertar notificacion
    $consultaCrearNotificacionNP = "INSERT INTO notificaciones(codigoAlumno, fecha, mensaje, asunto, visto) VALUES('$codigoAlumno', '$fechaCreacionNotificacion', '$mensajeNotificacionNP','NP', 'No')";     
    //Ejecutar consulta de insersión de notificación
    mysqli_query($conexion, $consultaCrearNotificacionNP);

}
if (strtolower($estadoFinalCita) =="postergado"){
    //Crear mensaje de notificación para el caso Postergado
    $mensajeNotificacionPostergado = "Tu cita programada para el ".$diaCita." ".$nroDiaCita." de ".$nombreMesCita." fue cancelada por tu docente, su motivo es: ".$observacion;
    //Crear consulta para insertar notificación
    $consultaCrearNotificacionPostergado = "INSERT INTO notificaciones(codigoAlumno, fecha, mensaje, asunto, visto) VALUES('$codigoAlumno', '$fechaCreacionNotificacion', '$mensajeNotificacionPostergado','Postergado', 'No')";
    //Ejecutar consulta de insersión de notificación
    mysqli_query($conexion, $consultaCrearNotificacionPostergado);
}

?>