<?php
session_start();
if (is_null($_SESSION["tipoUsuario"])){
    header("location: login.html");
}

//Conectarse a la base de datos
include 'config.php';

// Obtener los datos del estudiante
$alumno_cod = $_SESSION['codigo'];
$alumno_nombre = $_SESSION['name'];
$alumno_apellido = $_SESSION['surname'];
$alumno_codigo = $_SESSION['codigo'];
$id_tutor = $_SESSION["codTutor"];  //obtener en base al alumno

// RUTINA 5 : Actualizar horario del alumno despues de confirmar una cita
// Primero colocar en RECHAZADO todas las citas que estan en pendiente pero 
// que ya paso de fecha
$consulta = "UPDATE cita SET estado = 'RECHAZADO' WHERE codigoAlumno = '$alumno_cod' AND fecha < NOW()";
mysqli_query($conexion,$consulta);

//Mostrar la disponibilidad del tutor
$consulta = "SELECT * FROM disponibilidad WHERE codigoTutor = '$id_tutor' AND estado = 'libre'";
$resultadoConsulta = mysqli_query($conexion, $consulta);
$filasdisponibilidad = mysqli_num_rows($resultadoConsulta);

//Consultar si hay citas pendientes y confirmadas
//echo "<p>$alumno_codigo</p>";
$consultaCitaPend = "SELECT * FROM cita WHERE codigoAlumno = '$alumno_codigo' and (estado = 'pendiente' or estado = 'confirmado')";
$resultadoConsultaCita = mysqli_query($conexion, $consultaCitaPend);
$filasCitasDisponibles = mysqli_num_rows($resultadoConsultaCita);

$fechaConsulta = '';
$horaInicio = '';
$horaFin = '';
$estado = '';
if($filasCitasDisponibles){
    //echo "<p>$filasCitasDisponibles</p>";
    while ($citaAlumno = mysqli_fetch_assoc($resultadoConsultaCita)) {
        $fechaConsulta = $citaAlumno["fecha"];
        $horaInicio = $citaAlumno["horaInicio"];  
        $horaFin = $citaAlumno["horaFin"];  
        $estado = $citaAlumno["estado"];
        //echo "<p>$fechaConsulta</p>";
    }
}

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
//Iterar dentro de $resultadoConsulta y obtener el codigo de disponibilidades
//Para mostrar al alumno las disponibilidades de su tutor
while($datosDisp = mysqli_fetch_assoc($resultadoConsulta)){
    
    //Obtener datos de los arreglos
    $dia = $datosDisp["dia"];
    $Hini = $datosDisp["horaInicio"];
    $Hfin = $datosDisp["horaFin"];
    $CodigoDisp = $Dias[$dia].$Hini.'-'.$Hfin;
    //agregar disponibilidades al arreglo
    array_push($disponibilidades,$CodigoDisp);
}

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
    <link rel="stylesheet" href="styles/ocultarYMostrar.css">
    <link rel="stylesheet" href="styles/razon_tutoria_style.css">
    <link rel="stylesheet" href="styles/notificacionesTutorias.css">
</head>
<body id="blurBackgroundA" class="principal_alumno">
    <div id="blurA">
        <div class="container_nav">
            <section class="navegacionGeneral">
                <!-- Links supeiores para notificacion, usuario y salir -->
                <header class="first_navegation">
                    <a href="#" onclick="efectoBlurANotificacion('dialogNotiAlumno','blurA','blurBackgroundA')">
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
                <!-- Barra de navegacion entre las paginas -->
                <header class="header_principal">
                    <nav class="navegacion_Principal">
                        <a href="principal_alumno.php" id="tutoriaItem" class="alternativa abierto" onclick="elegirPagina('tutoriaItem')">
                            <img src="images/tutoria.png" alt="">
                            Tutoria
                        </a>
                        <a href="muroAlumno.html" id="muroItem" class="alternativa" onclick="elegirPagina('muroItem')">
                            <img src="images/muro.png" alt="">
                            Muro
                        </a>
                        <a href="archivados.html" id="seguimItem" class="alternativa" onclick="elegirPagina('seguimItem')">
                            <img src="images/descargar.png" alt="">
                            Historial
                        </a>
                    </nav>
                </header>
            </section>
        </div>

        <!-- Leyenda de colores e informacion -->
        <section class="leyenda_colores"> 
            <div class="leyenda_colores--amarillo_claro leyenda_item">
                <div class="color_amarillo_claro leyenda_color"></div>
                <p class="texro_leyenda">Casillas que muestran la disponibilidad de su tutor no disponible</p>
            </div>
            <div class="leyenda_colores--amarillo leyenda_item">
                <div class="color_amarillo leyenda_color"></div>
                <p class="texro_leyenda">Casillas que muestran la disponibilidad de su tutor disponible</p>
            </div>
            <div class="leyenda_colores--verde leyenda_item">
                <div class="color_verde leyenda_color"></div>
                <p class="texto_leyenda">Solicitud de cita esperando a ser respondida</p>
            </div>
            <div class="leyenda_colores--azul leyenda_item">
                <div class="color_azul leyenda_color"></div>
                <p class="texto_leyenda">Cita confirmada</p>
            </div>

            <div class="leyenda_Recomendacion">
                <p class="texto_leyenda">Aqui se muestra la disponibilidad de su profesor, elija la casilla donde desea reservar una cita</p>
            </div>
        </section>

        <!-- Tabla para mostrar la disponibilidad -->
        <section class="horario__principal horario__alumno">
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
                        <a href="#" class="celdaP" id="LU7-8"></a>
                        <a href="#" class="celdaP" id="LU8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA7-8"></a>
                        <a href="#" class="celdaP" id="MA8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI7-8"></a>
                        <a href="#" class="celdaP" id="MI8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU7-8"></a>
                        <a href="#" class="celdaP" id="JU8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI7-8"></a>
                        <a href="#" class="celdaP" id="VI8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA7-8"></a>
                        <a href="#" class="celdaP" id="SA8-9"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO7-8"></a>
                        <a href="#" class="celdaP" id="DO8-9"></a>
                    </td>
                </tr>
                <tr>
                    <th>09:00 - 11:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU9-10"></a>
                        <a href="#" class="celdaP" id="LU10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA9-10"></a>
                        <a href="#" class="celdaP" id="MA10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI9-10"></a>
                        <a href="#" class="celdaP" id="MI10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU9-10"></a>
                        <a href="#" class="celdaP" id="JU10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI9-10"></a>
                        <a href="#" class="celdaP" id="VI10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA9-10"></a>
                        <a href="#" class="celdaP" id="SA10-11"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO9-10"></a>
                        <a href="#" class="celdaP" id="DO10-11"></a>
                    </td>
                </tr>
                <tr>
                    <th>11:00 - 13:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU11-12"></a>
                        <a href="#" class="celdaP" id="LU12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA11-12"></a>
                        <a href="#" class="celdaP" id="MA12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI11-12"></a>
                        <a href="#" class="celdaP" id="MI12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU11-12"></a>
                        <a href="#" class="celdaP" id="JU12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI11-12"></a>
                        <a href="#" class="celdaP" id="VI12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA11-12"></a>
                        <a href="#" class="celdaP" id="SA12-13"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO11-12"></a>
                        <a href="#" class="celdaP" id="DO12-13"></a>
                    </td>
                </tr>
                <tr>
                    <th>13:00 - 15:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU13-14"></a>
                        <a href="#" class="celdaP" id="LU14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA13-14"></a>
                        <a href="#" class="celdaP" id="MA14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI13-14"></a>
                        <a href="#" class="celdaP" id="MI14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU13-14"></a>
                        <a href="#" class="celdaP" id="JU14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI13-14"></a>
                        <a href="#" class="celdaP" id="VI14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA13-14"></a>
                        <a href="#" class="celdaP" id="SA14-15"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO13-14"></a>
                        <a href="#" class="celdaP" id="DO14-15"></a>
                    </td>
                </tr>
                <tr>
                    <th>15:00 - 17:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU15-16"></a>
                        <a href="#" class="celdaP" id="LU16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA15-16"></a>
                        <a href="#" class="celdaP" id="MA16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI15-16"></a>
                        <a href="#" class="celdaP" id="MI16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU15-16"></a>
                        <a href="#" class="celdaP" id="JU16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI15-16"></a>
                        <a href="#" class="celdaP" id="VI16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA15-16"></a>
                        <a href="#" class="celdaP" id="SA16-17"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO15-16"></a>
                        <a href="#" class="celdaP" id="DO16-17"></a>
                    </td>
                </tr>
                <tr>
                    <th>17:00 - 19:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU17-18"></a>
                        <a href="#" class="celdaP" id="LU18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA17-18"></a>
                        <a href="#" class="celdaP" id="MA18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI17-18"></a>
                        <a href="#" class="celdaP" id="MI18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU17-18"></a>
                        <a href="#" class="celdaP" id="JU18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI17-18"></a>
                        <a href="#" class="celdaP" id="VI18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA17-18"></a>
                        <a href="#" class="celdaP" id="SA18-19"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO17-18"></a>
                        <a href="#" class="celdaP" id="DO18-19"></a>
                    </td>
                </tr>
                <tr>
                    <th>19:00 - 21:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU19-20"></a>
                        <a href="#" class="celdaP" id="LU20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA19-20"></a>
                        <a href="#" class="celdaP" id="MA20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI19-20"></a>
                        <a href="#" class="celdaP" id="MI20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU19-20"></a>
                        <a href="#" class="celdaP" id="JU20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI19-20"></a>
                        <a href="#" class="celdaP" id="VI20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA19-20"></a>
                        <a href="#" class="celdaP" id="SA20-21"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO19-20"></a>
                        <a href="#" class="celdaP" id="DO20-21"></a>
                    </td>
                </tr>
                <tr>
                    <th>21:00 - 23:00</th>
                    <td>
                        <a href="#" class="celdaP" id="LU21-22"></a>
                        <a href="#" class="celdaP" id="LU22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MA21-22"></a>
                        <a href="#" class="celdaP" id="MA22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="MI21-22"></a>
                        <a href="#" class="celdaP" id="MI22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="JU21-22"></a>
                        <a href="#" class="celdaP" id="JU22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="VI21-22"></a>
                        <a href="#" class="celdaP" id="VI22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="SA21-22"></a>
                        <a href="#" class="celdaP" id="SA22-23"></a>
                    </td>
                    <td>
                        <a href="#" class="celdaP" id="DO21-22"></a>
                        <a href="#" class="celdaP" id="DO22-23"></a>
                    </td>
                </tr>
            </table>
        </section>
    </div>

    <!-- RUTINA 12 : Mostrar notificaciones de alumno -->
    <!-- Interfaz de notificaciones para el alumno -->
    <div class="notificacionesCita" id="dialogNotiAlumno">
    <!-- // MOSTRAR LA INTERFAZ DE NOTIFICACIONES : SUBRUTINA 1 -->
    <?php

    //Obtener las notificaciones para este alumno
    $consultaNotifAlumno = "SELECT * FROM notificaciones WHERE codigoAlumno = '$alumno_cod' AND visto = 'No'";
    $resConNotifAlumno = mysqli_query($conexion, $consultaNotifAlumno);
    $filasNotif = mysqli_num_rows($resConNotifAlumno);
    //echo "<p>$filasNotif</p>";

    //Obtener toda la informacion necesaria de la consulta para usarla en el frontend
    $InformacionNotificacionesAlumno = [];
    while($datosDisp = mysqli_fetch_assoc($resConNotifAlumno)){
        $InformacionNotificacionActual = array();

        array_push($InformacionNotificacionActual, $datosDisp["idNotificacion"]);
        array_push($InformacionNotificacionActual, $datosDisp["codigoAlumno"]);
        array_push($InformacionNotificacionActual, $datosDisp["fecha"]);
        array_push($InformacionNotificacionActual, $datosDisp["mensaje"]);
        array_push($InformacionNotificacionActual, $datosDisp["estado"]);
        array_push($InformacionNotificacionActual, $datosDisp["visto"]);

        array_push($InformacionNotificacionesAlumno,$InformacionNotificacionActual);
    }

    $i = 0;
    foreach($InformacionNotificacionesAlumno as &$InformacionCita){
        $idNotificacion = $InformacionCita[0];
        $codigoAlumno = $InformacionCita[1];
        $fecha = $InformacionCita[2];
        $mensaje = $InformacionCita[3];
        $estadoCita = $InformacionCita[4];  //Confirmado, Rechazado o Suspendido
        $visto = $InformacionCita[5];   //Si o No

        print "<div class='notificacionCita $i' id = '$i'>
                    <div class='mesanjeNotificacion'>
                        <p class='mensaje'>$mensaje</p>
                    </div>
                    <div class='botones'>
                        <button class='boton' onclick='revisarNotificacion($idNotificacion, $i)' >OK</button>
                    </div>
                </div>";
        //echo '<hr>';
        $i++;
    }
    //onclick='responderNotificacion($codigoAlumno, `$fecha`, $horaInicio, $i, 1)'
    ?>
    </div>


    <!-- LA interfaz para solicitar una cita -->
    <section class="formulario" id="dialog">
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
                <button class="button button--yellow" onclick="toggleAmarillo()" type="button">Solicitar</button>
                <button class="button button--red" onclick="toggleRed()" type="button">Cancelar</button>
            </div>
        </form>
    </section>

    <script src="scripts/navegacion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./scripts/principalAlumnoFunciones.js"></script>
    <script src="./scripts/popup.js"></script>
    <script src="./scripts/dividirDisponibilidades.js"></script>  
    <script src="./scripts/scroll.js"></script>
    
    <!-- RUTINA 12 : Mostrar notificaciones de alumno -->
    <!-- Actualizar en base de datos para no mostrar una notificacion vista -->
    <script>
        function revisarNotificacion(idNotificacion, idSolicitud){
            var solicitud = document.getElementById(idSolicitud);
            solicitud.classList.add('noMostrar')

            //Realizar una peticion ajax
            //Obtener parametros para la peticion
            var parametros = {
                "idNotificacion" : idNotificacion,
                "visto" : 'Si'
            };
            //Llamar al backend
            $.ajax({
                data: parametros,
                url: 'scripts/datosLecturaNotificacion.php',
                type: 'POST',
                success: function(mensaje_mostrar){
                        $('#mostrar').html(mensaje_mostrar);
                    }
            }).done(function(res){
                console.log(res);
            })
        }
    </script>

    <!--  PINTAR LAS CASILLAS DE AMARILLO, AZUL O VERDE SI CORRESPONDE -->
    <script>
        //Obtener las citas pendientes del alumno
        var citasDisponibles = '<?php echo $filasCitasDisponibles;?>'
        console.log('citas para este: '+citasDisponibles)
        //Restringir si hay alguna solicitud de cita ya pendiente 
        if(citasDisponibles > 0){
            console.log('tamos aqui ya que citasDisponibles > 0')
            var estado = '<?php echo $estado;?>';
            //Obtener variables de PHP para generar el id de la casilla correspondiente
            var dia = deFechaANombreDia('<?php echo $fechaConsulta;?>');
            var horaInicio = '<?php echo $horaInicio;?>';
            var horaFin = '<?php echo $horaFin;?>';
            //Obtener ID en base a su dia, hora de inicio y hora de fin
            let codigo = ObtenerCodigoDisponibilidad(dia,horaInicio,horaFin)
            console.log('estado'+estado)
            // RUTINA 5 : Actualizar horario del alumno despues de confirmar una cita
            if (estado == 'CONFIRMADO' | estado == 'Confirmado' ){
                console.log('Tenemos una cita confirmada')
                //Colorear el cuadro respectivo
                casilla = document.getElementById(codigo)
                casilla.classList.add("pintarAzul")
            }
            if (estado == 'PENDIENTE' | estado == 'Pendiente'){
                console.log('Tenemos una cita pendiente')
                //Colorear el cuadro respectivo
                casilla = document.getElementById(codigo)
                casilla.classList.add("pintarVerde")
            }
        }
        else{
            var arregloEnJson = '<?php echo json_encode($disponibilidades);?>';
            var ACodDisp = JSON.parse(arregloEnJson);
            console.log('Las casillas disponibles')
            console.log(ACodDisp)
            ACodNoDisp = obtenerCasillasNoDisponiblesAMostrar(ACodDisp);
            
            for(let i = 0; i < ACodDisp.length; i++){
                var celda = document.getElementById(ACodDisp[i]);
                celda.classList.add("pintarAmarillo");
            }
            //Bloquear las casillas que ya no estas disponibles para solicitar cita
            for(let i = 0; i < ACodNoDisp.length; i++){
                var celda = document.getElementById(ACodNoDisp[i]);
                celda.classList.remove("pintarAmarillo");
                celda.classList.add("pintarAmarilloClaro");
            }
        }

        //Obtener las casillas que ya no estan disponibles para solicitar cita
        function obtenerCasillasNoDisponiblesAMostrar(codigoCasillas) {
            var inicialesDiasDisp = [];
            var nroDiaHoy = ObtenerNumeroDiaHoy()
            //D7 L1 M2 Mi3 J4 V5 S6
            nroDiaHoy = nroDiaHoy == 0? 7 : nroDiaHoy;
            // Mapas (diccionarios)
            let nroDias = new Map();
            nroDias.set("LU",1);
            nroDias.set("MA",2);
            nroDias.set("MI",3);
            nroDias.set("JU",4);
            nroDias.set("VI",5);
            nroDias.set("SA",6);
            nroDias.set("DO",7);
            //Colocar cada casilla del dia que ya haya pasado
            for(let i = 0; i < codigoCasillas.length; i++){
                var codDia = codigoCasillas[i].slice(0,2)
                if(nroDias.get(codDia) <= nroDiaHoy){
                    inicialesDiasDisp.push(codigoCasillas[i]);
                }
            }
            console.log('Inicials: ',inicialesDiasDisp);
            return inicialesDiasDisp
        }

        // Domingo -> 1, Lunes -> 2, ...
        function ObtenerNumeroDiaHoy(){
            // crea un nuevo objeto `Date`
            var today = new Date();
            // obtener la fecha de hoy en formato `MM/DD/YYYY`
            var now = today.toLocaleDateString('en-US');

            var Xmas95 = new Date(now);
            //var Xmas95 = new Date('January 16, 2023 23:15:30');
            var weekday = Xmas95.getDay();
            console.log('hoy es:',weekday);

            return weekday
        }

    </script>

    <!-- MOSTRAR LA INTERFAZ PARA SOLICITAR CITA CON LOS VALORES ADECUADOS -->
    <script>
        // Generar la interfaz para solicitar una cita
        var celdas = document.getElementsByClassName("celdaP")

        for(let i = 0; i < celdas.length; i++){
            celdas[i].dataset.numero = i;

            celdas[i].onclick = function() {
                if(celdas[i].classList[2] != "pintarVerde" && celdas[i].classList[1] == "pintarAmarillo")
                {
                    ShowDialogAll('dialog', 'blurA','blurBackgroundA')
                    this.classList.add("pintarVerde");
                    
                }
                
                //obtener informacion de la interfaz y colocarla
                let datosHorario = obtenerDatosCasilleroSeleccionado();
                console.log('--------')
                console.log(datosHorario)
                let hIni = datosHorario[1];
                let hFin = datosHorario[2];
                let day = datosHorario[0];

                let Hora = "Hora : " + hIni + ":00 - " + hFin + ":00";
                let Dia = "Dia : " + day;
                document.getElementById("razon-Dia").innerHTML = Hora
                document.getElementById("razon-Hora").innerHTML = Dia

            }
        }

        function obtenerDatosCasilleroSeleccionado() {

            //Obtener las horas y dia
            let datosHorario;
            var casillasVerdes = document.getElementsByClassName("pintarVerde") 
            if(casillasVerdes.length > 0){
                //obtener informacion del casillero : LU10-11
                hora = casillasVerdes[0].id;
                //Llamar a la funcion LU10-11 -> ['Lunes','10','11']
                datosHorario = dividirInfoDisponibilidad(hora);
            }
            console.log(datosHorario);
            return datosHorario;
        }

        //Obtener valores de las casillas para preescribirlos en la solicitud
        //Obtener nombre y apellido
        var name = '<?php echo $alumno_nombre;?>';
        var apellido = '<?php echo $alumno_apellido;?>';
        document.getElementById("nombres").value = name;
        document.getElementById("apellidos").value = apellido;
    </script>

    <!-- REALIZAR ACCION AL SOLICITAR O CANCELAR UNA CITA -->
    <script>
        //Funcion al pulsar un boton amarillo para solicitar una cita
        function toggleAmarillo() {

        //Obtener los nombres y apellidos
        var name = '<?php echo $alumno_nombre;?>';
        var apellido = '<?php echo $alumno_apellido;?>';

        //Realizar la peticion ajax
        let datosHorario = obtenerDatosCasilleroSeleccionado();
        let horaInicio = datosHorario[1];
        let horaFin = datosHorario[2];
        let dia = datosHorario[0];
        var codAlumno = '<?php echo $alumno_codigo;?>';
        console.log('cod Alumno : '+codAlumno)
        var razon =  document.getElementById("razon").value;
        console.log('Aqui viene la razon')
        console.log(razon);
        //Obtener parametros para la peticion
        var parametros = {
            "horaInicio" : horaInicio,
            "horaFin" : horaFin,
            "dia" : dia,
            "codigoAlumno" : codAlumno,
            "razon" : razon
        };
        //Llamar al backend para actualizar los datos
        $.ajax({
            data: parametros,
            url: 'scripts/datosCita.php',
            type: 'POST',
            success: function(mensaje_mostrar){
                    $('#mostrar').html(mensaje_mostrar);
                }
        }).done(function(res){
            console.log(res);
        })
        //cerrar la ventana de realizar una solicitud y volver a la pantalla principal
        closeDialogAll('dialog','blurA','blurBackgroundA')
        }

        //Solo colocar las actividades que realizara, no colocar otro toggle() por que para ese
        // nuevo toggle recien se activara en la siguiente vez que se presione el boton
        function toggleRed() {
            var casillasVerdes = document.getElementsByClassName("pintarVerde") 
            for(let i = 0; i < casillasVerdes.length; i++){
                casillasVerdes[i].classList.remove("pintarVerde");
                console.log('Se removio')
            }
            closeDialogAll('dialog','blurA','blurBackgroundA')
        }

    </script>
</body>
</html>
