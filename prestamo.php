<?php
session_start();
include 'conexion.php'; // Asegúrate de tener tu conexión a la base de datos
include 'nav.php'; // Incluir el menú de navegación

// Verifica si el usuario es admin
if ($_SESSION['rol_desc'] != 'Admin') {
    header("Location: index.php"); // Redirige si no es admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Préstamo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Solicitar Préstamo</h2>
    <form method="POST" action="guardarPrestamo.php">
        <div class="form-group">
            <label for="usuario_id">Selecciona Usuario:</label>
            <select name="usuario_id" class="form-control" required>
                <?php
                // Consulta para obtener todos los usuarios
                $usuarios = mysqli_query($con, "SELECT * FROM usuarios");
                while ($usuario = mysqli_fetch_assoc($usuarios)) {
                    echo "<option value='{$usuario['id']}'>{$usuario['nombre']} {$usuario['apellido']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="libro_id">Selecciona Libro:</label>
            <select name="libro_id" class="form-control" required>
                <?php
                // Consulta para obtener todos los libros disponibles
                $libros = mysqli_query($con, "SELECT * FROM libros WHERE disponible = TRUE");
                while ($libro = mysqli_fetch_assoc($libros)) {
                    echo "<option value='{$libro['id']}'>{$libro['titulo']} - {$libro['autor']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Botón para solicitar préstamo -->
        <button type="submit" class="btn btn-primary">Solicitar Préstamo</button>
    </form>
</div>
</body>
</html>