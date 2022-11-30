<?php

// include '../Proyecto-Ing.-Software-I/config.php';
$conexion = mysqli_connect("localhost", "root","","dbtutorias", 3307);
session_start();

// Obtener el codigo del estudiante
$alumno_cod = $_SESSION['codigo'];
$id_tutor = 1545;  //obtener

$consulta = "SELECT * FROM disponibilidad WHERE codigoTutor = '$id_tutor'";
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
while($datosDisp = mysqli_fetch_assoc($resultadoConsulta)){
    
    //Obtener datos de los arreglos
    $dia = $datosDisp["dia"];
    $Hini = $datosDisp["horaInicio"];
    $Hfin = $datosDisp["horaFin"];
    $CodigoDisp = $Dias[$dia].$Hini.'-'.$Hfin;
    //agregar disponibilidades al arreglo
    array_push($disponibilidades,$CodigoDisp);
    
}
// var_dump($disponibilidades);
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
</head>
<body id="blurBackground">
    <section class="navegacionGeneral" id="blurNav">
        <header class="first_navegation">
            <a href="#">
                <img src="images/notificacion.png" alt="logo">
            </a>
            <div>
                <a href="" class="esp_Der">
                    <img src="images/user.png" alt="">
                </a>
                <a href="">
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
            </nav>
        </header>
    </section>

    <main>
        <section class="horario__principal" id="blur">
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
            <a href="#" onclick="toggle()" class="boton_horario">Actualizar horario</a>
        </section>
    </main>

    <script>
        var arregloEnJson = '<?php echo json_encode($disponibilidades);?>';
        var ACodDisp = JSON.parse(arregloEnJson);
        
        for(let i = 0; i < ACodDisp.length; i++){
            var celda = document.getElementById(ACodDisp[i]);
            celda.classList.add("pintarAmarillo");
        }
    </script>
</body>
</html>