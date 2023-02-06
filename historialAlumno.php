<?php
session_start();
if (is_null($_SESSION["tipoUsuario"])){
    header("location: login.html");
}
//Coneccion a la BD
include 'config.php';

// Obtener los datos del estudiante
$alumno_cod = $_SESSION['codigo'];
$alumno_nombre = $_SESSION['name'];
$alumno_apellido = $_SESSION['surname'];
$alumno_codigo = $_SESSION['codigo'];
$id_tutor = $_SESSION["codTutor"];
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
    <link rel="stylesheet" href="styles/razon_tutoria_style.css">
    <link rel="stylesheet" href="styles/dialogShowAndHide.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/archivados_style.css">

</head>
<body>
    <!-- Contenedor de nav -->
    <div class="container_nav">
        <!-- Navegacion principal -->
        <section class="navegacionGeneral">
            <header class="first_navegation">
                <a href="#" onclick="efectoBlurANotificacion()">
                    <img src="images/notificacion.png" alt="logo">
                </a>
                <div>
                    <a href="#" class="esp_Der" onclick="showModalDialog('dialogPerfil')">
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
                    <a href="principal_alumno.php" id="tutoriaItem" class="alternativa" onclick="elegirPagina('tutoriaItem')">
                        <img src="images/tutoria.png" alt="">
                        Tutoria
                    </a>
                    <a href="muroAlumno.php" id="muroItem" class="alternativa" onclick="elegirPagina('muroItem')">
                        <img src="images/muro.png" alt="">
                        Muro
                    </a>
                    <a href="historialAlumno.php" id="seguimItem" class="alternativa abierto" onclick="elegirPagina('seguimItem')">
                        <img src="images/descargar.png" alt="">
                        Historial
                    </a>
                </nav>
            </header>
        </section>
    </div>

    <dialog class="perfil perfil-alumno" id="dialogPerfil">
    <?php
        include './componentsPHP/usuarioAlumno.php';
    ?>
    </dialog>
    
    <!-- Main principal -->
    <main>
        <!-- Contenedor de archivados -->
        <section class="container">
            <!-- Archivados -->
            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>
            
            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>
            
            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>
            
            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>

            <div class="archivado">
                <div class="archivado__info">
                    <div class="archivado__texto">
                        <h4 class="archivado__prof">Juanita Huerfanita</h4>
                        <p class="archivado__fecha">08 de Noviembre 2022</p>
                        <p class="archivado__hora">7:00 am - 8:00 am</p>
                    </div>
                    <img src="images/img_prof_referencia.jpg" alt="imagen_profesor" class="archivado__img">
                </div>
                <div class="archivado__infestado">
                    <p class="archivado__estado">Estado Final</p>
                </div>
            </div>
        </section>
    </main>

    <script src="scripts/navegacion.js"></script>
    <script src="./scripts/scroll.js"></script>
</body>
</html>