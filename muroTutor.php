<?php
session_start();
if (is_null($_SESSION["tipoUsuario"])){
    header("location: login.html");
}
//Coneccion a la BD
include 'config.php';

// Obtener el codigo del tutor
$id_tutor = $_SESSION['codigo'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Muro</title>
    	<link rel="stylesheet" href="styles/normalize.css">
    	<link rel="stylesheet" href="styles/styles.css">
        <link rel="stylesheet" href="styles/muro_style.css">
        <link rel="stylesheet" href="styles/dialogShowAndHide.css">
        <link rel="stylesheet" href="styles/razon_tutoria_style.css">
        <link rel="stylesheet" href="styles/profile.css">
    </head>
    <body>
        <!-- Contenedor de nav -->
        <section class="container_nav">
            <!-- Navegacion principal -->
            <section class="navegacionGeneral">
                <header class="first_navegation">
                    <a href="#" onclick="efectoBlurANotificacion()">
                        <!-- <img src="images/notificacion.png" alt="logo"> -->
                    </a>
                    <div>
                        <a href="#" class="esp_Der" id="perfilBoton">
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
                        <a href="muroTutor.php" id="muroItem" class="alternativa abiert" onclick="elegirPagina('muroItem')">
                            <img src="images/muro.png" alt="">
                            Muro
                        </a>
                        <a href="archivadosTutor.php" id="seguimItem" class="alternativa" onclick="elegirPagina('seguimItem')">
                            <img src="images/descargar.png" alt="">
                            Seguimiento
                        </a>
                    </nav>
                </header>
            </section>
        </section>
        
        <!-- Contenedor de links para articulos universitarios -->
        <section class="contenidoAdicional">
            <a href="https://revistas.unsaac.edu.pe/" target="_blank" id="button" class="button">Revistas Unsaac</a>       
            <a href="http://www.unsaac.edu.pe/index.php/universidad/institucional/eventos" target="_blank" class="button" id="button">Eventos Unsaac</a>
            <a href="http://www.unsaac.edu.pe/index.php/universidad/institucional/bolsa-de-trabajo" class="button" target="_blank" id="button">Bolsa de Trabajo Unsaac</a>
            <!-- <button class="button">Link de interés</button> -->
        </section>

        <!-- Contenedor de articulos -->
        <section class="articulos"> 
            <!-- Articulos -->
            <article class="articulo">
                <img src="./images/img_lectura.jpg" alt="imagen_articulo" class="articulo_img">
                <div class="articulo_textcont">
                    <h4 class="articulo_textcont_tittle">MEJOR COMPRENSION DE LECTURA</h4>
                    <p class="articulo_textcont_p">Para mejorar tu comprensión lectora, debes leer despacio cada línea. Así te sentirás obligado a entender oración por oración. Pausas: Haz una pausa cada párrafo, para continuar tu lectura. Analiza lo leído para asegurarte que lo entendiste...</p>
                    <div class="container_button">
                        <a href="" class="button">Ver más</a>
                    </div>
                </div>
            </article>
            
            <article class="articulo">
                <img src="./images/img_referencia.jpg" alt="imagen_articulo" class="articulo_img">
                <div class="articulo_textcont">
                    <h4 class="articulo_textcont_tittle">BUENAS PRACTICAS DE PROGRAMACION</h4>
                    <p class="articulo_textcont_p">La mayoría de profesionales relacionados con la informática se ven en la necesidad de escribir código en algún momento. En este sentido, es más que recomendable seguir una serie de protocolos y de buenas prácticas para programadores... </p>
                    <div class="container_button">
                        <a href="" class="button">Ver más</a>
                    </div>
                </div>
            </article>

            <article class="articulo">
                <img src="./images/img_future.jfif" alt="imagen_articulo" class="articulo_img">
                <div class="articulo_textcont">
                    <h4 class="articulo_textcont_tittle">FUTURO DE LA PROGRAMACION</h4>
                    <p class="articulo_textcont_p">En un mundo cada vez más digital es necesario contar con programadores informáticos en cualquier tipo de empresa. Se trata de una de las profesiones con menos desempleo en todo el mundo y que está en constante evolución...</p>
                    <div class="container_button">
                        <a href="" class="button">Ver más</a>
                    </div>
                </div>
            </article>
        </section>

        <dialog class="perfil perfil-tutor" id="dialogPerfil">
        <?php
            include './componentsPHP/usuarioTutor.php';
        ?>

        </dialog>

        <script>
            const boton = document.getElementById('perfilBoton');
            console.log("boton")

            boton.addEventListener("click", function(evento){
                console.log('click')
                showModalDialog('dialogPerfil');
            })

            function showModalDialog(idDialog){
                const modal = document.getElementById(idDialog);
                setTimeout(() => {
                    modal.classList.add('mostrarModal')
                }, 1);
                modal.showModal();
            }

            function hideModalDialog(idDialog){
                const modal = document.getElementById(idDialog);
                modal.classList.remove('mostrarModal');
                modal.addEventListener('animationend', closeModal);
                modal.classList.add('close');

                function closeModal() {
                    modal.close();
                    modal.classList.remove('close');
                    modal.removeEventListener('animationend', closeModal);
                }
            }
        </script>

        <script src="./scripts/dialogShowAndHide.js"></script>
        <script src="./scripts/navegacion.js"></script>
        <script src="./scripts/scroll.js"></script>

        
    </body>
</html>
