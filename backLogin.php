<?php
//Recuperar datos del formulariodel login
$correo = $_POST["user"];
$contrasenia = $_POST["password"];

//Realizar conexión con la base de datos
$conexion = mysqli_connect("localhost", "root","","dbtutorias");
//----------------------------------Crear consultas----------------------------------
//Consultar como alumno
$consultaAlumno = "SELECT*FROM Alumno where correoAlumno='$correo' and contrasenia='$contrasenia'";
$resultadoAlumno = mysqli_query($conexion, $consultaAlumno);
$filasAlumnos = mysqli_num_rows($resultadoAlumno);
session_start();
//Verificar si se inició sesión como alumno
if($filasAlumnos){
    //Llenar datos
    $_SESSION["tipoUsuario"] = "alumno";
    while ($datosAlumno = mysqli_fetch_assoc($resultadoAlumno)) {
        $_SESSION["codigo"] = $datosAlumno["codigoAlumno"];
        $_SESSION["name"] = $datosAlumno["nombres"];
        $_SESSION["surname"] = $datosAlumno["apellidos"]; 
    }
    //Mandar al menu
    header("location: index.html");
}
else{
    //Verificar si se inicio sesión como tutor
    //Consultar como tutor
    $consultaTutor = "SELECT*FROM Tutor where correoTutor='$correo' and contrasenia='$contrasenia'";
    $resultadoTutor = mysqli_query($conexion, $consultaTutor);
    $filasTutor = mysqli_num_rows($resultadoTutor);
    if($filasTutor){
        $_SESSION["tipoUsuario"] = "tutor";
        while ($datosTutor = mysqli_fetch_assoc($resultadoTutor)) {
            //Llenar datos
            $_SESSION["codigo"] =  $datosTutor["codigoTutor"];
            $_SESSION["name"] = $datosTutor["nombres"];
            $_SESSION["surname"] = $datosTutor["apellidos"]; 
        }
        //Mandar al menu
        header("location:index.html");
    }
    else{
        //Los datos ingresados son incorrectos, mandar al login
        header("location: login.html");
    }
}
?>