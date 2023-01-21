<?php 
//Conectar con la base de datos
include "../config.php";
//Recibir datos de petición ajax
$idNotifi = $_POST["idNotificacion"];
//Crear consulta para actualizar estado de la notificación
$consultaMarcarVisto = "UPDATE notificaciones SET visto='Si' where idNotificacion='$idNotifi'";
//Ejecutar consulta
mysqli_query($conexion, $consultaMarcarVisto);
?>