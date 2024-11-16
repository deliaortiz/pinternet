<?php
session_start();
include 'conexion.php'; // Asegúrate de tener tu conexión a la base de datos

// Verifica si el usuario es admin
if ($_SESSION['rol_desc'] != 'Admin') {
    header("Location: index.php"); // Redirige si no es admin
    exit();
}

// Obtener roles y maestros para los selects
$roles = mysqli_query($con, "SELECT * FROM roles");
$maestras = mysqli_query($con, "SELECT * FROM Maestra");
$personas = mysqli_query($con, "SELECT * FROM personas"); // Obtener personas para el select

// Transformar los resultados en arrays
$rolesArray = mysqli_fetch_all($roles, MYSQLI_ASSOC);
$maestrasArray = mysqli_fetch_all($maestras, MYSQLI_ASSOC);
$personasArray = mysqli_fetch_all($personas, MYSQLI_ASSOC); // Asegúrate de no tener caracteres extraños aquí
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Agregar Usuario</h2>
    <form method="POST" action="guardarUsuario.php">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <!-- Agrega más campos según sea necesario -->

        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
    </form>
</div>
</body>
</html>