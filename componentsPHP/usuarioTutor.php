<?php
/*echo "<p>$id_tutor</p>";*/

$id_tutor = 1234;

$consultaTutor = "SELECT * FROM tutor  WHERE codigoTutor = '$id_tutor' ";

//Ejecutar consulta
$resultadoConsultaTutor = mysqli_query($conexion, $consultaTutor);
//var_dump($disponibilidades);
$numTutores = mysqli_num_rows($resultadoConsultaTutor);


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

?>

<div class="container_user">
    <img src="./images/usuario_2.png" alt="imagen_user" class="container_user__img">
    <div class="container_user__info">
        <div class="container_user__square">
            <p class="containter_user__name" id="containter_user__name">JHON FERNANDEZ GUEVARA</p>
        </div>
        <div class="containter_user__text">
            <div class="containter_user__datos" id="containter_user__datos"> 
                <p>CORREO:</p> 
                <p id='correo'>181420@unsaac.edu.pe</p> 
            </div>
        </div>
        <button class="button button-profile-OK" type="button" onclick="hideModalDialog('dialogPerfil')">OK</button>
    </div>
    
</div>

<script>
    var datosTutoJson = '<?php echo json_encode($datosDelTutor);?>';
    var datosTutor = JSON.parse(datosTutoJson);

    var user_name = 'JUAN PEREZ MARTINEZ'
    document.getElementById('containter_user__name').innerText = datosTutor[1]+' '+datosTutor[2];
    document.getElementById('correo').innerText = datosTutor[0];
</script>