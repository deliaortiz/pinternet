<?php
// Inicializa la sesion o reanuda una existente
session_start();
//verifica si se inicia la sesion 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
	
}//archivo de conexion, contiene la logica de conexion de la base de datos
include("conexion.php");
?>
<!--codigo html-->
<!DOCTYPE html>
<html lang="es">
<head><!--cabecera de la pagina-->

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administración</title>

	<!-- estilos de Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">


	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<!--esto es lo que contiene la pagina-->
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>E-Commerce Admin: <?php echo $_SESSION['user_name']; ?></h2>
			<hr />
</body>
</html>