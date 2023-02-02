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
//COMPONENTE : obtener disponibilidades de BD del tutor asignado
$consulta = "SELECT * FROM disponibilidad WHERE codigoTutor = '$id_tutor' AND estado = 'libre'";
$resultadoConsulta = mysqli_query($conexion, $consulta);
$filasdisponibilidad = mysqli_num_rows($resultadoConsulta);

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
    <link rel="stylesheet" href="styles/dialogShowAndHide.css">
</head>
<body id="blurBackgroundA" class="principal_alumno">
    <div id="blurA">
        <div class="container_nav">
            <section class="navegacionGeneral">
                <!-- Links supeiores para notificacion, usuario y salir -->
                <header class="first_navegation">
                    <a href="#" onclick="showModalDialog('dialogNotiAlumno')">
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
        <?php
        include './componentsPHP/horarioAlumno.php';
        ?>
        </section>
    </div>

    <!-- RUTINA 12 : Mostrar notificaciones de alumno -->
    <!-- Interfaz de notificaciones para el alumno -->
    <dialog class="notificaciones-container" id="dialogNotiAlumno">
        <div class="notificacionesCita">
        <!-- // MOSTRAR LA INTERFAZ DE NOTIFICACIONES : SUBRUTINA 1 -->
        <?php

        // COMPONENTE: Obtener notificaciones de la BD
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
            array_push($InformacionNotificacionActual, $datosDisp["asunto"]);
            array_push($InformacionNotificacionActual, $datosDisp["visto"]);

            array_push($InformacionNotificacionesAlumno,$InformacionNotificacionActual);
        }

        // COMPONENTE : Mostrar notificaciones 
        $i = 0;
        foreach($InformacionNotificacionesAlumno as &$InformacionCita){
            $idNotificacion = $InformacionCita[0];
            $codigoAlumno = $InformacionCita[1];
            $fecha = $InformacionCita[2];
            $mensaje = $InformacionCita[3];
            //$estadoCita = $InformacionCita[4]; 
            $visto = $InformacionCita[5];   //Si o No

            // COMPONENTE : Mostrar notificacion
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
        <button class="botonCerrar" onclick="hideModalDialog('dialogNotiAlumno')">x</button>
    </dialog>

    <!-- COMPONENTE : ver interfaz de solicitar cita -->
    <!-- LA interfaz para solicitar una cita -->
    <dialog class="formulario" id="dialog">
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
    </dialog>

    <script src="./scripts/dialogShowAndHide.js"></script>
    <script src="scripts/navegacion.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./scripts/popup.js"></script>
    <script src="./scripts/dividirDisponibilidades.js"></script>  
    <script src="./scripts/scroll.js"></script>
    
    <!-- RUTINA 12 : Mostrar notificaciones de alumno -->
    <!-- Actualizar en base de datos para no mostrar una notificacion vista -->
    <script>
        // COMPONENTE : revisarNotificacion
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

    <!-- REALIZAR ACCION AL SOLICITAR O CANCELAR UNA CITA -->
    <script>
/*
        setTimeout(() => {
            //Despintar las casillas amarillas
            var casillasAmarillas = document.getElementsByClassName("pintarAmarillo") 
            console.log('Pintar las casillas amarillas ->>')
            console.log(casillasAmarillas)
            for(let i = 0; i < casillasAmarillas.length; i++){
                casillasAmarillas[i].classList.remove("pintarAmarillo");
                console.log('Se removio las casillas amarillas')
            }
        }, 2000);*/

        

        //Funcion al pulsar un boton amarillo para solicitar una cita
        // COMPONENTE : Solicitar una cita
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
            var razon =  document.getElementById("razon").value;
            //Obtener parametros para la peticion
            var parametros = {
                "horaInicio" : horaInicio,
                "horaFin" : horaFin,
                "dia" : dia,
                "codigoAlumno" : codAlumno,
                "razon" : razon
            };

            //INTERFAZ : 
            //Llamar al backend para actualizar los datos
            $.ajax({
                data: parametros,
                url: 'scripts/datosCita.php',
                type: 'POST',
                success: function(mensaje_mostrar){
                        //alert(mensaje_mostrar);
                    },
                error: function(){
                    //alert("Ocurrio un error")
                }
            })
                    
            //cerrar la ventana de realizar una solicitud y volver a la pantalla principal
            //console.log('llego hasta aqui, ya casi a cerrar')
            hideModalDialog('dialog')
            //Se despintaran las casillas que no sea una verde
            DespintarDemasCasillas()
        }

        //Solo colocar las actividades que realizara, no colocar otro toggle() por que para ese
        // nuevo toggle recien se activara en la siguiente vez que se presione el boton
        function toggleRed() {

            //Despintar las casillas verdes
            var casillasVerdes = document.getElementsByClassName("pintarVerde") 
            for(let i = 0; i < casillasVerdes.length; i++){
                casillasVerdes[i].classList.remove("pintarVerde");
                console.log('Se removio')
            }
            hideModalDialog('dialog')
        }

        function DespintarDemasCasillas(){
            console.log('Intentando despintar')
            var celdas = document.getElementsByClassName("celdaP")

            for(let i = 0; i < celdas.length; i++){
                celdas[i].dataset.numero = i;

                if(celdas[i].classList[2] != "pintarVerde")
                {
                    celdas[i].classList.add("despintar");
                }
            }
        }

    </script>

    <!-- MOSTRAR LA INTERFAZ PARA SOLICITAR CITA CON LOS VALORES ADECUADOS -->
    <script>
        // Generar la interfaz para solicitar una cita
        // COMPONENTE : Actualizar datos del casillero seleccionado
        
        //actualizar Datos Al Seleccionar Una Casilla Para Seleccionar una Cita
        function actualizarDatosAlSeleccionarCita() {
            var celdas = document.getElementsByClassName("celdaP")
            for(let i = 0; i < celdas.length; i++){
                celdas[i].dataset.numero = i;

                celdas[i].onclick = function() {
                    if(celdas[i].classList[2] != "pintarVerde" && celdas[i].classList[1] == "pintarAmarillo")
                    {
                        //ShowDialogAll('dialog', 'blurA','blurBackgroundA')
                        showModalDialog('dialog')
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
        }

        actualizarDatosAlSeleccionarCita()

        // COMPONENTE : Obtener datos del casillero seleccionado
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
</body>
</html>
