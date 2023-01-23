<?php

session_start();
if (is_null($_SESSION["tipoUsuario"])){
    header("location: login.html");
}
//Coneccion a la BD
include 'config.php';

// Obtener el codigo del tutor
$id_tutor = $_SESSION['codigo'];

//Obtener todas las citas que tuvo el tutor
$consulta = "SELECT * FROM cita INNER JOIN alumno ON cita.codigoAlumno = alumno.codigoAlumno WHERE codigoTutor = '$id_tutor'";
$resultadoConsulta = mysqli_query($conexion, $consulta);
$numCitasTutor = mysqli_num_rows($resultadoConsulta);

$InformacionTodasCitas = [];
while($datosDisp = mysqli_fetch_assoc($resultadoConsulta)){
    $InformacionCita = array();

    array_push($InformacionCita, $datosDisp["nombres"]);
    array_push($InformacionCita, $datosDisp["apellidos"]);
    array_push($InformacionCita, $datosDisp["codigoAlumno"]);
    array_push($InformacionCita, $datosDisp["fecha"]);
    array_push($InformacionCita, $datosDisp["horaInicio"]);
    array_push($InformacionCita, $datosDisp["horaFin"]);
    array_push($InformacionCita, $datosDisp["estado"]);
    array_push($InformacionCita, $datosDisp["razon"]);
    array_push($InformacionCita, $datosDisp["observacion"]);

    array_push($InformacionTodasCitas,$InformacionCita);
}

//echo "<p>$numCitasTutor</p>";
//var_dump($InformacionTodasCitas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivados</title>
    <!-- Insertar estilos -->
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/archivados_style.css">
</head>
<body>
    <!-- Contenedor de nav -->
    <section class="container_nav">
        <!-- Navegacion principal -->
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
            <header class="header_principal">
                    <nav class="navegacion_Principal">
                    <a href="principal_tutor.php" id="tutoriaItem" class="alternativa" onclick="elegirPagina('tutoriaItem')">
                        <img src="images/tutoria.png" alt="">
                        Tutoria
                    </a>
                    <a href="muroTutor.html" id="muroItem" class="alternativa" onclick="elegirPagina('muroItem')">
                        <img src="images/muro.png" alt="">
                        Muro
                    </a>
                    <a href="archivadosTutor.php" id="seguimItem" class="alternativa abiert" onclick="elegirPagina('seguimItem')">
                        <img src="images/descargar.png" alt="">
                        Seguimiento
                    </a>
                </nav>
            </header>
        </section>
    </section>

    <section class="menuSeguimiento">
        <button onclick="elegirAlternativaSeg('todas')" id="todas" class="alternativa abierto">Todas</button>
        <button onclick="elegirAlternativaSeg('realizadas')" id="realizadas" class="alternativa">realizadas</button>
        <button onclick="elegirAlternativaSeg('postergadas')" id="postergadas" class="alternativa">postergadas</button>
        <button onclick="elegirAlternativaSeg('ausentes')" id="ausentes" class="alternativa">no realizadas</button>
    </section>
    
    <!-- Main principal -->
    <main>
        <!-- Contenedor de archivados -->
        <section class="container">
        <?php
        $i = 0;
        if(count($InformacionTodasCitas) > 0){
            foreach($InformacionTodasCitas as &$InformacionCita){

            $nombreAlumno = $InformacionCita[0];
            $apellidoAlumno = $InformacionCita[1];
            $codigoAlumno = $InformacionCita[2];
            $fecha = $InformacionCita[3];
            $horaInicio = $InformacionCita[4];
            $horaFin = $InformacionCita[5];
            $estado = $InformacionCita[6];
            $razon = $InformacionCita[7];
            $observacion = $InformacionCita[8];

                print "<!-- Archivados -->
                        <div class='archivado $estado'>
                            <div class='archivado__info'>
                                <div class='archivado__texto'>
                                    <h4 class='archivado__prof'>$nombreAlumno $apellidoAlumno</h4>
                                    <p class='archivado__fecha'>$fecha</p>
                                    <p class='archivado__hora'>$horaInicio:00 - $horaFin:00</p>
                                </div>
                                <img src='images/img_prof_referencia.jpg' alt='imagen_profesor' class='archivado__img'>
                            </div>
                            <div class='archivado__infestado'>
                                <p class='archivado__estado'>$estado</p>
                            </div>
                        </div>";
    
                $i++;
            }
        }
        else {
            print "<div>No hay citas</div>";
        }
        ?>
        </section>
    </main>

    <script src="./scripts/scroll.js"></script>

    <!-- mantener solo una opcion de eleccion activa -->
    <script>
        function elegirAlternativaSeg(tipoAlternativa){
            console.log('Estado clickeado: ',tipoAlternativa)
            var alternativas = document.getElementsByClassName('alternativa')
            for(alternativa of alternativas){
                alternativa.classList.remove("abierto");
            }
            document.getElementById(tipoAlternativa).classList.add('abierto')
        
            var contenedoresCitas = document.getElementsByClassName('archivado')

            if(tipoAlternativa == 'todas'){
                for(contenedor of contenedoresCitas){
                    contenedor.classList.remove('noMostrar')
                }
            }
            if(tipoAlternativa == 'realizadas'){
                for(contenedor of contenedoresCitas){
                    contenedor.classList.remove('noMostrar')
                    if(contenedor.classList[1] != 'REALIZADO' & contenedor.classList[1] != 'Realizado'){
                        contenedor.classList.add('noMostrar')
                    }
                }
            }
            if(tipoAlternativa == 'postergadas'){
                for(contenedor of contenedoresCitas){
                    contenedor.classList.remove('noMostrar')
                    if(contenedor.classList[1] != 'POSTERGADO' & contenedor.classList[1] != 'Postergado'){
                        contenedor.classList.add('noMostrar')
                    }
                }
            }
            if(tipoAlternativa == 'ausentes'){
                for(conenedor of contenedoresCitas){
                    contenedor.classList.remove('noMostrar')
                    if(conenedor.classList[1] != 'NP'){
                        conenedor.classList.add('noMostrar')
                    }
                }
            }
        
        }
    </script>

    <script src="scripts/navegacion.js"></script>
</body>
</html>