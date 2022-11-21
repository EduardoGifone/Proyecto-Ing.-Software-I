<?php
//Abrir sesión
session_start();
//Destruir sesión
session_destroy();
//Mandar a ventana de login
header("location: login.html");
?>