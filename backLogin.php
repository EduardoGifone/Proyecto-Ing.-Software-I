<?php
// echo "Mensaje de prueba";
//Recuperar datos
$user = $_POST["usuario"];
$pass = $_POST["password"];
//Iniciar sesion
session_start();
//Conectar con la base de datos
include "config.php";
//Verificar existencia de usuario
$queryAlumno = "SELECT * FROM alumno where correoAlumno='$user'";
$resultadoAlumno = mysqli_query($conexion, $queryAlumno);
if (mysqli_num_rows($resultadoAlumno)){
    //Validar contraseña
    $queryPass = "SELECT * FROM alumno where contrasenia = '$pass' and correoAlumno='$user' ";
    $resultadoPass = mysqli_query($conexion, $queryPass);
    $filasAlumno = mysqli_num_rows($resultadoPass);
    if ($filasAlumno){
        $_SESSION["tipoUsuario"] = "alumno";
        while ($datosAlumno = mysqli_fetch_assoc($resultadoPass)) {
            $_SESSION["codigo"] = $datosAlumno["codigoAlumno"];
            $_SESSION["name"] = $datosAlumno["nombres"];
            $_SESSION["surname"] = $datosAlumno["apellidos"]; 
            $_SESSION["codTutor"] = $datosAlumno["codigoTutor"];  
        }
        echo "menuAlumno";
    }
    else{
        echo "Contraseña incorrecta";
    }
}
else{
    // Consultar como docente
    $queryTutor = "SELECT * FROM tutor where correoTutor='$user'";
    $resultadoTutor = mysqli_query($conexion, $queryTutor);
    if (mysqli_num_rows($resultadoTutor)){
        //Verificar contraseña
        $queryTutorPassword = "SELECT * FROM tutor WHERE contrasenia='$pass' and correoTutor='$user'";
        $resultadoPasswordTutor = mysqli_query($conexion, $queryTutorPassword);
        if(mysqli_num_rows($resultadoPasswordTutor)){
            $_SESSION["tipoUsuario"] = "tutor";
            while ($datosTutor = mysqli_fetch_assoc($resultadoPasswordTutor)) {
                //Llenar datos
                $_SESSION["codigo"] =  $datosTutor["codigoTutor"];
                $_SESSION["name"] = $datosTutor["nombres"];
                $_SESSION["surname"] = $datosTutor["apellidos"]; 
            }
            echo "menuTutor";
        }
        else{
            echo "contraseña incorrecta";
        }
    }
    else{
        echo "El correo ingresado no existe";
    }
}
?>
