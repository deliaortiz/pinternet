<?php
// este codigo es para cerrar la sesion


//se inicia la sesion 
session_start();
 
// elimina las variables para cerrar la sesion 
$_SESSION = array();
 
// Destruye la sesin 
session_destroy();
 
// dirige al login 
header("location: login.php");
exit;
?>