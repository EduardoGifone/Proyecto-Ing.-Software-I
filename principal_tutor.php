<?php
session_start();
if (is_null($_SESSION["tipoUsuario"])){
    header("location: login.html");
}

// include '../Proyecto-Ing.-Software-I/config.php';
include 'config.php';

// Obtener el codigo del estudiante
$id_tutor = $_SESSION['codigo'];

$consulta = "SELECT * FROM disponibilidad WHERE codigoTutor = '$id_tutor' AND estado='libre'";
$resultadoConsulta = mysqli_query($conexion, $consulta);
$filasdisponibilidad = mysqli_num_rows($resultadoConsulta);

//para almacenar los codigos de las disponibilidades
$disponibilidades = [];
$Dias = array(
    "Lunes" => "LU",
    "Martes" =>"MA",
    "Miercoles" => "MI",
    "Jueves" => "JU",
    "Viernes" => "VI",
    "Sabado" => "SA",
    "Domingo" => "DO"

);

$Days = array(
    "Monday" => "LU",
    "Tuesday" =>"MA",
    "Wednesday" => "MI",
    "Thursday" => "JU",
    "Friday" => "VI",
    "Saturday" => "SA",
    "Sunday" => "DO"

);
if($filasdisponibilidad > 0){
    while($datosDisp = mysqli_fetch_assoc($resultadoConsulta)){
    
        //Obtener datos de los arreglos
        $dia = $datosDisp["dia"];
        $Hini = $datosDisp["horaInicio"];
        $Hfin = $datosDisp["horaFin"];
        $CodigoDisp = $Dias[$dia].$Hini.'-'.$Hfin;
        //agregar disponibilidades al arreglo
        array_push($disponibilidades,$CodigoDisp);
        
    }
}
// var_dump($disponibilidades);


// MOSTRAR LA INTERFAZ DE NOTIFICACIONES : SUBRUTINA 1
$consulta = "SELECT * FROM cita INNER JOIN alumno ON cita.codigoAlumno = alumno.codigoAlumno WHERE codigoTutor = '$id_tutor' AND estado = 'PENDIENTE'";
$resConCitasPendientes = mysqli_query($conexion, $consulta);
$filasCitas = mysqli_num_rows($resConCitasPendientes);

/*echo "<p>$filasCitas</p>";*/

$InformacionCitasPendientes = [];
while($datosDisp = mysqli_fetch_assoc($resConCitasPendientes)){
    $InformacionCitasPendiente = array();

    array_push($InformacionCitasPendiente, $datosDisp["nombres"]);
    array_push($InformacionCitasPendiente, $datosDisp["apellidos"]);
    array_push($InformacionCitasPendiente, $datosDisp["codigoAlumno"]);
    array_push($InformacionCitasPendiente, $datosDisp["fecha"]);
    array_push($InformacionCitasPendiente, $datosDisp["razon"]);
    array_push($InformacionCitasPendiente, $datosDisp["horaInicio"]);
    array_push($InformacionCitasPendiente, $datosDisp["horaFin"]);

    array_push($InformacionCitasPendientes,$InformacionCitasPendiente);
}

// RUTINA 4 : Actualizar horario del tutor después de confirmar una cita

//Obtener las fechas del lunes y el domingo de esta semana para mostrar solo las citas de esta semana
function ObtenerLunesYDomingoFechasEstaSemana(){
    $nroDiaToday = date('N');
  
    $MondayThisWeek = time() - ( (($nroDiaToday)-1) * 24 * 60 * 60 );  
    $SundayThisWeek = time() - ( (($nroDiaToday-6)-1) * 24 * 60 * 60 ); 

    $MondayThisWeek_fecha = date('Y-m-d', $MondayThisWeek);
    $SundayThisWeek_fecha = date('Y-m-d', $SundayThisWeek);

    $fechasLunesDomingo = array();
    array_push($fechasLunesDomingo, $MondayThisWeek_fecha);
    array_push($fechasLunesDomingo, $SundayThisWeek_fecha);

    return $fechasLunesDomingo;
}

$fechasLunesDomingo = ObtenerLunesYDomingoFechasEstaSemana();
//Restringir solo obtener las citas confirmadas para esta semana

//SUBRUTINA 4.1 : Obtener nombre del dia partiendo de la fecha
function obtenerNombreDiaFechaActual($fecha){
    $fechats = strtotime($fecha);
    $nombreFecha = date('l', $fechats);
    return $nombreFecha;
}

$consultaCitasConfirmadas = "SELECT * FROM cita INNER JOIN alumno ON cita.codigoAlumno = alumno.codigoAlumno WHERE codigoTutor = '$id_tutor' AND estado = 'CONFIRMADO' AND fecha >= '$fechasLunesDomingo[0]' AND fecha <= '$fechasLunesDomingo[1]'";
$resCitasConfirmadas = mysqli_query($conexion, $consultaCitasConfirmadas);
$filasCitasConf = mysqli_num_rows($resCitasConfirmadas);
echo "<p>$filasCitasConf</p>";

$InformacionCitasConfirmadas = [];
while($datosDisp = mysqli_fetch_assoc($resCitasConfirmadas)){
    $InformacionCitaConfirmada = array();

    array_push($InformacionCitaConfirmada, $datosDisp["nombres"]);
    array_push($InformacionCitaConfirmada, $datosDisp["apellidos"]);
    array_push($InformacionCitaConfirmada, $datosDisp["codigoAlumno"]);
    array_push($InformacionCitaConfirmada, $datosDisp["fecha"]);
    array_push($InformacionCitaConfirmada, $datosDisp["razon"]);
    array_push($InformacionCitaConfirmada, $datosDisp["horaInicio"]);
    array_push($InformacionCitaConfirmada, $datosDisp["horaFin"]);
    array_push($InformacionCitaConfirmada, $datosDisp["estado"]);

    //Agregar el id de la casilla perteneciente a dicha cita
    //obtener acronimo del dia
    $nombreDia = obtenerNombreDiaFechaActual($datosDisp["fecha"]);
    if ($nombreDia != ''){
        $claveDia = $Days[$nombreDia];
        
        //Obtener datos de los arreglos
        $dia = $nombreDia;
        //echo "<p>$datosDisp['fecha']</p>";
        $Hini = $datosDisp["horaInicio"];
        $Hfin = $datosDisp["horaFin"];
        $CodigoDisp = $Days[$dia].$Hini.'-'.$Hfin;
        array_push($InformacionCitaConfirmada, $CodigoDisp);
    }

    array_push($InformacionCitasConfirmadas,$InformacionCitaConfirmada);
}

//Agregar los id's de las citas confirmadas a los arreglos de informacion


?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorias</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/principal_tutor_stylesV2.css">
    <link rel="stylesheet" href="styles/notificacionesTutorias.css">
    <link rel="stylesheet" href="styles/razon_tutoria_style.css">
</head>
<body id="blurBackground" class="principal_tutor">
    <div id="blur">
        <section class="navegacionGeneral">
            <header class="first_navegation">
                <a href="#" onclick="efectoBlurANotificacion()">
                    <img src="images/notificacion.png" alt="logo">
                </a>
                <div>
                    <a href="" class="esp_Der">
                        <img src="images/user.png" alt="">
                    </a>
                    <a href="destroySession.php">
                        <img src="images/closeSesion.png" alt="">
                    </a>
                </div>
            </header>
            <hr class="line">
            <header>
                <nav class="navegacion_Principal">
                    <a href="#">
                        <img src="images/tutoria.png" alt="">
                        Tutoria
                    </a>
                    <a href="#">
                        <img src="images/muro.png" alt="">
                        Muro
                    </a>
                    <a href="#">
                        <img src="images/comunidad.png" alt="">
                        Comunidad
                    </a>
                    <a href="#">
                        <img src="images/descargar.png" alt="">
                        Archivados
                    </a>
                </nav>
            </header>
        </section>

        <section class="horario__principal">
            <table border="1" class="tabla__horario">
                <tr>
                    <th class="encabezado">HORAS</th>
                    <th class="encabezado">LUNES</th>
                    <th class="encabezado">MARTES</th>
                    <th class="encabezado">MIERCOLES</th>
                    <th class="encabezado">JUEVES</th>
                    <th class="encabezado">VIERNES</th>
                    <th class="encabezado">SABADO</th>
                    <th class="encabezado">DOMINGO</th>
                </tr>
                <tr>
                    <th>07:00 - 09:00</th>
                    <td>
                        <a href="#" class="celdaP LU7-8" id="LU7-8"></a>
                        <a href="#" class="celdaP LU8-9" id="LU8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA7-8" id="MA7-8"></a>
                        <a href="#" class="celdaP MA8-9" id="MA8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI7-8" id="MI7-8"></a>
                        <a href="#" class="celdaP MI8-9" id="MI8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU7-8" id="JU7-8"></a>
                        <a href="#" class="celdaP JU8-9" id="JU8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI7-8" id="VI7-8"></a>
                        <a href="#" class="celdaP VI8-9" id="VI8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA7-8" id="SA7-8"></a>
                        <a href="#" class="celdaP SA8-9" id="SA8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO7-8" id="DO7-8"></a>
                        <a href="#" class="celdaP DO8-9" id="DO8-9"></a>
                    </td>
                </tr>
                <tr>
                    <th>09:00 - 11:00</th>
                    <td>
                        <a href="#" class="celdaP LU9-10" id="LU9-10"></a>
                        <a href="#" class="celdaP LU10-11" id="LU10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA9-10" id="MA9-10"></a>
                        <a href="#" class="celdaP MA10-11" id="MA10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI9-10" id="MI9-10"></a>
                        <a href="#" class="celdaP MI10-11" id="MI10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU9-10" id="JU9-10"></a>
                        <a href="#" class="celdaP JU10-11" id="JU10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI9-10" id="VI9-10"></a>
                        <a href="#" class="celdaP VI10-11" id="VI10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA9-10" id="SA9-10"></a>
                        <a href="#" class="celdaP SA10-11" id="SA10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO9-10" id="DO9-10"></a>
                        <a href="#" class="celdaP DO10-11" id="DO10-11"></a>
                    </td>
                </tr>
                <tr>
                    <th>11:00 - 13:00</th>
                    <td>
                        <a href="#" class="celdaP LU11-12" id="LU11-12"></a>
                        <a href="#" class="celdaP LU12-13" id="LU12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA11-12" id="MA11-12"></a>
                        <a href="#" class="celdaP MA12-13" id="MA12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI11-12" id="MI11-12"></a>
                        <a href="#" class="celdaP MI12-13" id="MI12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU11-12" id="JU11-12"></a>
                        <a href="#" class="celdaP JU12-13" id="JU12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI11-12" id="VI11-12"></a>
                        <a href="#" class="celdaP VI12-13" id="VI12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA11-12" id="SA11-12"></a>
                        <a href="#" class="celdaP SA12-13" id="SA12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO11-12" id="DO11-12"></a>
                        <a href="#" class="celdaP DO12-13" id="DO12-13"></a>
                    </td>
                </tr>
                <tr>
                    <th>13:00 - 15:00</th>
                    <td>
                        <a href="#" class="celdaP LU13-14" id="LU13-14"></a>
                        <a href="#" class="celdaP LU14-15" id="LU14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA13-14" id="MA13-14"></a>
                        <a href="#" class="celdaP MA14-15" id="MA14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI13-14" id="MI13-14"></a>
                        <a href="#" class="celdaP MI14-15" id="MI14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU13-14" id="JU13-14"></a>
                        <a href="#" class="celdaP JU14-15" id="JU14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI13-14" id="VI13-14"></a>
                        <a href="#" class="celdaP VI14-15" id="VI14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA13-14" id="SA13-14"></a>
                        <a href="#" class="celdaP SA14-15" id="SA14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO13-14" id="DO13-14"></a>
                        <a href="#" class="celdaP DO14-15" id="DO14-15"></a>
                    </td>
                </tr>
                <tr>
                    <th>15:00 - 17:00</th>
                    <td>
                        <a href="#" class="celdaP LU15-16" id="LU15-16"></a>
                        <a href="#" class="celdaP LU16-17" id="LU16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA15-16" id="MA15-16"></a>
                        <a href="#" class="celdaP MA16-17" id="MA16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI15-16" id="MI15-16"></a>
                        <a href="#" class="celdaP MI16-17" id="MI16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU15-16" id="JU15-16"></a>
                        <a href="#" class="celdaP JU16-17" id="JU16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI15-16" id="VI15-16"></a>
                        <a href="#" class="celdaP VI16-17" id="VI16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA15-16" id="SA15-16"></a>
                        <a href="#" class="celdaP SA16-17" id="SA16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO15-16" id="DO15-16"></a>
                        <a href="#" class="celdaP DO16-17" id="DO16-17"></a>
                    </td>
                </tr>
                <tr>
                    <th>17:00 - 19:00</th>
                    <td>
                        <a href="#" class="celdaP LU17-18" id="LU17-18"></a>
                        <a href="#" class="celdaP LU18-19" id="LU18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA17-18" id="MA17-18"></a>
                        <a href="#" class="celdaP MA18-19" id="MA18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI17-18" id="MI17-18"></a>
                        <a href="#" class="celdaP MI18-19" id="MI18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU17-18" id="JU17-18"></a>
                        <a href="#" class="celdaP JU18-19" id="JU18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI17-18" id="VI17-18"></a>
                        <a href="#" class="celdaP VI18-19" id="VI18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA17-18" id="SA17-18"></a>
                        <a href="#" class="celdaP SA18-19" id="SA18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO17-18" id="DO17-18"></a>
                        <a href="#" class="celdaP DO18-19" id="DO18-19"></a>
                    </td>
                </tr>
                <tr>
                    <th>19:00 - 21:00</th>
                    <td>
                        <a href="#" class="celdaP LU19-20" id="LU19-20"></a>
                        <a href="#" class="celdaP LU20-21" id="LU20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA19-20" id="MA19-20"></a>
                        <a href="#" class="celdaP MA20-21" id="MA20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI19-20" id="MI19-20"></a>
                        <a href="#" class="celdaP MI20-21" id="MI20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU19-20" id="JU19-20"></a>
                        <a href="#" class="celdaP JU20-21" id="JU20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI19-20" id="VI19-20"></a>
                        <a href="#" class="celdaP VI20-21" id="VI20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA19-20" id="SA19-20"></a>
                        <a href="#" class="celdaP SA20-21" id="SA20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO19-20" id="DO19-20"></a>
                        <a href="#" class="celdaP DO20-21" id="DO20-21"></a>
                    </td>
                </tr>
                <tr>
                    <th>21:00 - 23:00</th>
                    <td>
                        <a href="#" class="celdaP LU21-22" id="LU21-22"></a>
                        <a href="#" class="celdaP LU22-23" id="LU22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MA21-22" id="MA21-22"></a>
                        <a href="#" class="celdaP MA22-23" id="MA22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP MI21-22" id="MI21-22"></a>
                        <a href="#" class="celdaP MI22-23" id="MI22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP JU21-22" id="JU21-22"></a>
                        <a href="#" class="celdaP JU22-23" id="JU22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP VI21-22" id="VI21-22"></a>
                        <a href="#" class="celdaP VI22-23" id="VI22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP SA21-22" id="SA21-22"></a>
                        <a href="#" class="celdaP SA22-23" id="SA22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP DO21-22" id="DO21-22"></a>
                        <a href="#" class="celdaP DO22-23" id="DO22-23"></a>
                    </td>
                </tr>
            </table>
            <button href="#" onclick="showDialog()" class="boton_horario">Actualizar horario</button>
        </section>
    </div>
    <section class="horario__actualizar" id="dialog">
        <table border="1" class="tabla__horario">
            <tr>
                <th class="encabezado">HORAS</th>
                <th class="encabezado">LUNES</th>
                <th class="encabezado">MARTES</th>
                <th class="encabezado">MIERCOLES</th>
                <th class="encabezado">JUEVES</th>
                <th class="encabezado">VIERNES</th>
                <th class="encabezado">SABADO</th>
                <th class="encabezado">DOMINGO</th>
            </tr>
            <tr>
                <th>07:00 - 09:00</th>
                <td>
                    <a href="#" class="celda LU7-8" id="LU7-8"></a>
                    <a href="#" class="celda LU8-9" id="LU8-9"></a>
                </td>
                <td>
                    <a href="#" class="celda MA7-8" id="MA7-8"></a>
                    <a href="#" class="celda MA8-9" id="MA8-9"></a>
                </td>
                <td>
                    <a href="#" class="celda MI7-8" id="MI7-8"></a>
                    <a href="#" class="celda MI8-9" id="MI8-9"></a>
                </td>
                <td>
                    <a href="#" class="celda JU7-8" id="JU7-8"></a>
                    <a href="#" class="celda JU8-9" id="JU8-9"></a>
                </td>
                <td>
                    <a href="#" class="celda VI7-8" id="VI7-8"></a>
                    <a href="#" class="celda VI8-9" id="VI8-9"></a>
                </td>
                <td>
                    <a href="#" class="celda SA7-8" id="SA7-8"></a>
                    <a href="#" class="celda SA8-9" id="SA8-9"></a>
                </td>
                <td>
                    <a href="#" class="celda DO7-8" id="DO7-8"></a>
                    <a href="#" class="celda DO8-9" id="DO8-9"></a>
                </td>
            </tr>
            <tr>
                <th>09:00 - 11:00</th>
                <td>
                    <a href="#" class="celda LU9-10" id="LU9-10-"></a>
                    <a href="#" class="celda LU10-11" id="LU10-11-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA9-10" id="MA9-10-"></a>
                    <a href="#" class="celda MA10-11" id="MA10-11-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI9-10" id="MI9-10-"></a>
                    <a href="#" class="celda MI10-11" id="MI10-11-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU9-10" id="JU9-10-"></a>
                    <a href="#" class="celda JU10-11" id="JU10-11-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI9-10" id="VI9-10-"></a>
                    <a href="#" class="celda VI10-11" id="VI10-11-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA9-10" id="SA9-10-"></a>
                    <a href="#" class="celda SA10-11" id="SA10-11-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO9-10" id="DO9-10-"></a>
                    <a href="#" class="celda DO10-11" id="DO10-11-"></a>
                </td>
            </tr>
            <tr>
                <th>11:00 - 13:00</th>
                <td>
                    <a href="#" class="celda LU11-12" id="LU11-12-"></a>
                    <a href="#" class="celda LU12-13" id="LU12-13-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA11-12" id="MA11-12-"></a>
                    <a href="#" class="celda MA12-13" id="MA12-13-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI11-12" id="MI11-12-"></a>
                    <a href="#" class="celda MI12-13" id="MI12-13-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU11-12" id="JU11-12-"></a>
                    <a href="#" class="celda JU12-13" id="JU12-13-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI11-12" id="VI11-12-"></a>
                    <a href="#" class="celda VI12-13" id="VI12-13-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA11-12" id="SA11-12-"></a>
                    <a href="#" class="celda SA12-13" id="SA12-13-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO11-12" id="DO11-12-"></a>
                    <a href="#" class="celda DO12-13" id="DO12-13-"></a>
                </td>
            </tr>
            <tr>
                <th>13:00 - 15:00</th>
                <td>
                    <a href="#" class="celda LU13-14" id="LU13-14-"></a>
                    <a href="#" class="celda LU14-15" id="LU14-15-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA13-14" id="MA13-14-"></a>
                    <a href="#" class="celda MA14-15" id="MA14-15-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI13-14" id="MI13-14-"></a>
                    <a href="#" class="celda MI14-15" id="MI14-15-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU13-14" id="JU13-14-"></a>
                    <a href="#" class="celda JU14-15" id="JU14-15-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI13-14" id="VI13-14-"></a>
                    <a href="#" class="celda VI14-15" id="VI14-15-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA13-14" id="SA13-14-"></a>
                    <a href="#" class="celda SA14-15" id="SA14-15-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO13-14" id="DO13-14-"></a>
                    <a href="#" class="celda DO14-15" id="DO14-15-"></a>
                </td>
            </tr>
            <tr>
                <th>15:00 - 17:00</th>
                <td>
                    <a href="#" class="celda LU15-16" id="LU15-16-"></a>
                    <a href="#" class="celda LU16-17" id="LU16-17-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA15-16" id="MA15-16-"></a>
                    <a href="#" class="celda MA16-17" id="MA16-17-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI15-16" id="MI15-16-"></a>
                    <a href="#" class="celda MI16-17" id="MI16-17-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU15-16" id="JU15-16-"></a>
                    <a href="#" class="celda JU16-17" id="JU16-17-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI15-16" id="VI15-16-"></a>
                    <a href="#" class="celda VI16-17" id="VI16-17-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA15-16" id="SA15-16-"></a>
                    <a href="#" class="celda SA16-17" id="SA16-17-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO15-16" id="DO15-16-"></a>
                    <a href="#" class="celda DO16-17" id="DO16-17-"></a>
                </td>
            </tr>
            <tr>
                <th>17:00 - 19:00</th>
                <td>
                    <a href="#" class="celda LU17-18" id="LU17-18-"></a>
                    <a href="#" class="celda LU18-19" id="LU18-19-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA17-18" id="MA17-18-"></a>
                    <a href="#" class="celda MA18-19" id="MA18-19-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI17-18" id="MI17-18-"></a>
                    <a href="#" class="celda MI18-19" id="MI18-19-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU17-18" id="JU17-18-"></a>
                    <a href="#" class="celda JU18-19" id="JU18-19-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI17-18" id="VI17-18-"></a>
                    <a href="#" class="celda VI18-19" id="VI18-19-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA17-18" id="SA17-18-"></a>
                    <a href="#" class="celda SA18-19" id="SA18-19-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO17-18" id="DO17-18-"></a>
                    <a href="#" class="celda DO18-19" id="DO18-19-"></a>
                </td>
            </tr>
            <tr>
                <th>19:00 - 21:00</th>
                <td>
                    <a href="#" class="celda LU19-20" id="LU19-20-"></a>
                    <a href="#" class="celda LU20-21" id="LU20-21-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA19-20" id="MA19-20-"></a>
                    <a href="#" class="celda MA20-21" id="MA20-21-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI19-20" id="MI19-20-"></a>
                    <a href="#" class="celda MI20-21" id="MI20-21-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU19-20" id="JU19-20-"></a>
                    <a href="#" class="celda JU20-21" id="JU20-21-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI19-20" id="VI19-20-"></a>
                    <a href="#" class="celda VI20-21" id="VI20-21-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA19-20" id="SA19-20-"></a>
                    <a href="#" class="celda SA20-21" id="SA20-21-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO19-20" id="DO19-20-"></a>
                    <a href="#" class="celda DO20-21" id="DO20-21-"></a>
                </td>
            </tr>
            <tr>
                <th>21:00 - 23:00</th>
                <td>
                    <a href="#" class="celda LU21-22" id="LU21-22-"></a>
                    <a href="#" class="celda LU22-23" id="LU22-23-"></a>
                </td>
                <td>
                    <a href="#" class="celda MA21-22" id="MA21-22-"></a>
                    <a href="#" class="celda MA22-23" id="MA22-23-"></a>
                </td>
                <td>
                    <a href="#" class="celda MI21-22" id="MI21-22-"></a>
                    <a href="#" class="celda MI22-23" id="MI22-23-"></a>
                </td>
                <td>
                    <a href="#" class="celda JU21-22" id="JU21-22-"></a>
                    <a href="#" class="celda JU22-23" id="JU22-23-"></a>
                </td>
                <td>
                    <a href="#" class="celda VI21-22" id="VI21-22-"></a>
                    <a href="#" class="celda VI22-23" id="VI22-23-"></a>
                </td>
                <td>
                    <a href="#" class="celda SA21-22" id="SA21-22-"></a>
                    <a href="#" class="celda SA22-23" id="SA22-23-"></a>
                </td>
                <td>
                    <a href="#" class="celda DO21-22" id="DO21-22-"></a>
                    <a href="#" class="celda DO22-23" id="DO22-23-"></a>
                </td>
            </tr>
        </table>
        <button href="#" class="boton_horario" id="BtnActualizar">Actualizar</button>
    </section>
    <div class="notificacionesCita" id="dialogNoti">
    <!-- // MOSTRAR LA INTERFAZ DE NOTIFICACIONES : SUBRUTINA 1 -->
    <?php
    $i = 0;
    foreach($InformacionCitasPendientes as &$InformacionPendiente){
        $nombreAlumno = $InformacionPendiente[0];
        $apellidoAlumno = $InformacionPendiente[1];
        $codigoAlumno = $InformacionPendiente[2];
        $fecha = $InformacionPendiente[3];
        $razon = $InformacionPendiente[4];
        $horaInicio = $InformacionPendiente[5];
        $horaFin = $InformacionPendiente[6];

        print "<div class='notificacionCita $fecha $horaInicio $i' id = '$i'>
                    <div class='fechaHora'>
                        <p class='fecha'>Fecha '$fecha'</p>
                        <p class='hora'>Hora: $horaInicio:00</p>
                    </div>
                    <div class='nombreTutorado'>
                        <p>$nombreAlumno $apellidoAlumno</p>
                    </div>
                    <div class='razonTutoria'>
                        <p>$razon</p>
                    </div>
                    <div class='botones'>
                        <button class='boton btn_izq' onclick='responderCita($codigoAlumno, `$fecha`, $horaInicio, $i, 1)'>Aceptar</button>
                        <button class='boton btn_der' onclick='responderCita($codigoAlumno, `$fecha`, $horaInicio, $i, 0)'>No aceptar</button>
                    </div>
                </div>";
        //echo '<hr>';
        $i++;
    }
    ?>
    </div>
  
    <section class="formulario" id="dialogInformacionCita">
        <form action="" class="razon_tutoria">
            <div class="razon__fecha_hora">
                <p class="razon__txt" id="razon-Dia">Fecha: 28/01/23</p>
                <p class="razon__txt" id="razon-Hora">Hora: 8:00 pm</p>
            </div>

            <label for="nombres" class="form_label">Nombres</label>
            <input id="nombres" name="nombres" type="text" required class="razon_input razon_input--nombres" readonly="readonly">

            <label for="apellidos" class="form_label">Apellidos</label>
            <input id="apellidos" name="apellidos" type="text" required class="razon_input razon_input--apellidos">

            <label for="razon" class="form_label">Razon de la tutoria</label>
            <textarea id="razon" name="razon" class="razon_input razon_input--textarea"></textarea>

            <div class="buttons">
                <button class="button button--yellow" onclick="toggleAmarillo()" type="submit">Finalizar</button>
                <button class="button button--red" onclick="toggleRed()" type="submit">Suspender</button>
            </div>
        </form>
    </section>

    <script src="scripts/popup.js"></script>
    <script>
        var arregloEnJson = '<?php echo json_encode($disponibilidades);?>';
        var ACodDisp = JSON.parse(arregloEnJson);
        
        for(let i = 0; i < ACodDisp.length; i++){
            var celda = document.getElementById(ACodDisp[i]);
            celda.classList.add("pintarAmarillo");
            var celdasEleccion = document.getElementById(ACodDisp[i]+'-');
            celdasEleccion.classList.add("pintarAmarillo");
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="scripts/dividirDisponibilidades.js"></script>
    <script src="scripts/actualizarHorario.js"></script>

    <script>
        // MOSTRAR LA INTERFAZ DE NOTIFICACIONES : SUBRUTINA 1
        var citasPendientesJson = '<?php echo json_encode($InformacionCitasPendientes);?>'
        var InformacionCitasPendientes = JSON.parse(citasPendientesJson);
        console.log('Arreglo de citas pendientes');
        console.log(InformacionCitasPendientes);


        function revisarOtrasCitasEnMismaHora(fecha, horaInicio){

            var citasMostradas = document.getElementsByClassName('notificacionCita');
            console.log(citasMostradas)
            for(var i = 0; i < citasMostradas.length; i++){
                console.log(citasMostradas[i].classList[1]+'  '+fecha)
                console.log(citasMostradas[i].classList[2]+'  '+horaInicio)
                if(citasMostradas[i].classList[1] == fecha & citasMostradas[i].classList[2] == horaInicio){
                    var citaMostaraElem = document.getElementById(citasMostradas[i].classList[3]);
                    citaMostaraElem.classList.add('noMostrar')
                }
            }
        }

        // ACEPTAR UNA CITA : RUTINA 2 y 3
        function responderCita(codigoAlumno, fecha, horaInicio, idSolicitud, numRespuesta){
            var solicitud = document.getElementById(idSolicitud);
            solicitud.classList.add('noMostrar')
            revisarOtrasCitasEnMismaHora(fecha, horaInicio)

            var respuesta = 'Rechazado';
            if(numRespuesta == 1){
                respuesta = 'Aceptado';
            }
            
            //Realizar una peticion ajax
            //Obtener parametros para la peticion
            var parametros = {
                "codigoAlumno" : codigoAlumno,
                "fecha" : fecha,
                "horaInicio" : horaInicio,
                "respuesta" : respuesta
            };
            //Llamar al backend
            $.ajax({
                data: parametros,
                url: 'scripts/datosRespuestaCita.php',
                type: 'POST',
                success: function(mensaje_mostrar){
                        $('#mostrar').html(mensaje_mostrar);
                    }
            }).done(function(res){
                console.log(res);
            })
        }
    </script>

    <script>
        // RUTINA 4 : Actualizar horario del tutor después de confirmar una cita
        var citasConfirmadasJson = '<?php echo json_encode($InformacionCitasConfirmadas);?>';
        var InformacionCitasConfirmadas = JSON.parse(citasConfirmadasJson);
        console.log('Citas confirmadas')
        console.log(InformacionCitasConfirmadas)

        for(let i = 0; i < InformacionCitasConfirmadas.length; i++){
            var celda = document.getElementById(InformacionCitasConfirmadas[i][8]);
            celda.classList.add("pintarAzul");
        }

        // RUTINA 8 : Mostrar informacion del alumno al hacer click en una casilla azul
        var celdas_P = document.getElementsByClassName("celdaP")
        console.log('Celdas P mostrandose en la rutina 8')
        console.log(celdas_P)
        for(let i = 0; i < celdas_P.length; i++){
            celdas_P[i].dataset.numero = i;
            
            
            celdas_P[i].onclick = function() {
                
                //Restringir que al clickear otras celdas no pase nada
                if (celdas_P[i].classList[2] == 'pintarAzul'){

                    //Obtener id de celda clickeada
                    var codCeldaClickeada = celdas_P[i].classList;

                    //Comparar con las los valores de las citas confirmadas
                    for(var j = 0; j < InformacionCitasConfirmadas.length; j++){
                        if(InformacionCitasConfirmadas[j][8] == codCeldaClickeada[1]){
                            //Obtener los valores que necesitamos
                            var name = InformacionCitasConfirmadas[j][0]
                            var apellido = InformacionCitasConfirmadas[j][1]
                            var razonTuto = InformacionCitasConfirmadas[j][4]
                        }
                    }

                    //Mostrar el que si corresponde
                    document.getElementById("nombres").value = name;
                    document.getElementById("apellidos").value = apellido;
                    document.getElementById("razon").value = razonTuto;
                
                    //Mostrar y ocultar la ventana de informacion cuando sea necesario
                    showDialogInformacion()

                }
            }
        }
    </script>
</body>
</html>