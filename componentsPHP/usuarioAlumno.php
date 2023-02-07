<?php
// echo "<p>$alumno_cod</p>";

/*$id_tutor = 1234;*/

$consultaAlumno = "SELECT * FROM alumno  WHERE codigoAlumno = '$alumno_cod' ";
$consultaTutor = "SELECT * FROM tutor  WHERE codigoTutor = '$id_tutor' ";

//Ejecutar consulta
$resultadoConsultaAlumno = mysqli_query($conexion, $consultaAlumno);
//var_dump($disponibilidades);
$numAlumnos = mysqli_num_rows($resultadoConsultaAlumno);

//Ejecutar consulta
$resultadoConsultaTutor = mysqli_query($conexion, $consultaTutor);
//var_dump($disponibilidades);
$numTutores = mysqli_num_rows($resultadoConsultaTutor);

//Obtener datos del tutor
$datosDelTutor = [];
//Recorrer datos
if ($numTutores > 0){
    while ($datosTutor = mysqli_fetch_assoc($resultadoConsultaTutor)){
        //Obtener clave primaria de citas
        array_push($datosDelTutor,$datosTutor["correoTutor"]);
        array_push($datosDelTutor,$datosTutor["nombres"]);
        array_push($datosDelTutor,$datosTutor["apellidos"]);
    }
}

$datosDelAlumno = [];
//Recorrer datos
if ($numAlumnos > 0){
    while ($datosAlumno = mysqli_fetch_assoc($resultadoConsultaAlumno)){
        //Obtener clave primaria de citas
        array_push($datosDelAlumno,$datosAlumno["correoAlumno"]);
        array_push($datosDelAlumno,$datosAlumno["nombres"]);
        array_push($datosDelAlumno,$datosAlumno["apellidos"]);
        array_push($datosDelAlumno,$datosAlumno["semestre"]);
    }
}

?>

<div class="container_user container_user--alumno">
    <img src="./images/usuario_2.png" alt="imagen_user" class="container_user__img">
    <div class="container_user__info">
        <div class="container_user__square">
            <p class="containter_user__name" id="containter_user__name">JHON FERNANDEZ GUEVARA</p>
        </div>
        <div class="containter_user__text">
            <div class="containter_user__datos" id="containter_user__datos"> 
                <p>CORREO:</p> 
                <p id='correo'>alguien@xxxxxx.com</p> 
            </div>
            <div class="containter_user__datos" id="containter_user__datos"> 
                <p>TUTOR:</p> 
                <p id='tutor'>Tutor Tutor</p> 
            </div>
            <div class="containter_user__datos" id="containter_user__datos"> 
                <p>SEMESTRE:</p> 
                <p id='semestre'>20XX-X</p> 
            </div>
        </div>
        <button class="button button-profile-OK" type="button" onclick="hideModalDialog('dialogPerfil')">OK</button>
    </div>
    
</div>

<script src="./scripts/dialogShowAndHide.js"></script>
<script>

    var datosAlumnoJson = '<?php echo json_encode($datosDelAlumno);?>';
    var datosAlumno = JSON.parse(datosAlumnoJson);
    var datosTutoJson = '<?php echo json_encode($datosDelTutor);?>';
    var datosTutor = JSON.parse(datosTutoJson);

    document.getElementById('containter_user__name').innerText = datosAlumno[1]+' '+datosAlumno[2];
    document.getElementById('correo').innerText = datosAlumno[0];
    document.getElementById('tutor').innerText = datosTutor[1]+' '+datosTutor[2];
    document.getElementById('semestre').innerText = datosAlumno[3];

</script>