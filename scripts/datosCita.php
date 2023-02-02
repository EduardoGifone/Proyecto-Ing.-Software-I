<?php
//Función para obtenr días de diferencia
function obtenerDiferenciaDias($nroDia){
    //--------------------- Obtener fecha actual ---------------------
    //Establecer zona horario (Perú)
    date_default_timezone_set('America/Lima');
    // Obtener una lista con la fecha actual 
    $fechaHoy = date('N-d-m-Y-H-i');    //(numberDay, day, month, year, hour, minute)
    $lista = explode('-', $fechaHoy);
    $diference = $nroDia - $lista[0];
    return $diference;
}
//Función para validar día seleccionado
function validarDiaSeleccionado($nroDia, $horaInicio){
    //Establecer un límite de horas de anticipación con que la cita debe ser reservada
    $limite = 5;
    //Obtener días de diferencia respecto a la fecha actual
    $diference = obtenerDiferenciaDias($nroDia);
    //---------------- Validar día seleccionado ----------------
    if ($diference < 0){    //El día seleccionado ya pasó
        // echo "El día ya pasó";
        return 0;
    }
    else if ($diference == 0){   //El día es hoy
        //Obtener hora actual
        $fechaHoy = date('N-d-m-Y-H-i');    //(numberDay, day, month, year, hour, minute)
        $lista = explode('-', $fechaHoy);
        $horaActual = $lista[4];
        //Validar hora
        if($horaInicio - $horaActual < $limite){
            // echo "Nope";
            return 0;
        }
    }
    return 1;
}
function enviarReservaBD($nroDia, $horaInicio, $horaFin, $codigo, $razon){
    //Definir si el día seleccionado es correcto
    $var = validarDiaSeleccionado($nroDia, $horaInicio);
    if ($var){
        //Obtener días de diferencia respecto a la fecha actual
        $diference = obtenerDiferenciaDias($nroDia);
        //-----------------------Enviar reserva a la base de datos-----------------------
        // COMPONENTE : Crear una cita en estado pendiente en DB
        $fecha = date_create();
        date_add($fecha, date_interval_create_from_date_string($diference." days"));
        $newDate = date_format($fecha,"Y-m-d");
        //Conectar con la base de datos
        include '../config.php';
        //Crear consulta
        $consulta = "INSERT INTO cita values('$newDate','$horaInicio','$horaFin','$codigo','PENDIENTE','$razon',null)";
        //Ejecutar consulta
        if (mysqli_query($conexion, $consulta)){
            echo "Se reservo la cita";
        }
        else{
            echo "Error en Mysql";
        } 
    }
}
//Obtener informacion de la peticion ajax
$horaInicio = $_POST["horaInicio"];
$horaFin = $_POST["horaFin"];
$dia = strtolower($_POST["dia"]);
$codigo = $_POST["codigoAlumno"];
$razon = $_POST["razon"];
//Generar número de día
$days = array(1=>"lunes",2=>"martes",3=>"miercoles",4=>"jueves",5=>"viernes",6=>"sabado",7=>"domingo");
$nroDia = array_search($dia,$days);
//Llamar a función para reservar cita
enviarReservaBD($nroDia, $horaInicio, $horaFin, $codigo, $razon);
?>