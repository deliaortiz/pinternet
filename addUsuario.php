<?php
session_start();
include 'conexion.php'; // Asegúrate de tener tu conexión a la base de datos

// Verifica si el usuario es admin
if ($_SESSION['rol_desc'] != 'Admin') {
    header("Location: index.php"); // Redirige si no es admin
    exit();
}

// Obtener roles y maestros para los selects
$roles = $pdo->query("SELECT * FROM roles")->fetchAll();
$maestras = $pdo->query("SELECT * FROM Maestra")->fetchAll();
$personas = $pdo->query("SELECT * FROM personas")->fetchAll(); // Obtener personas para el select
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
            <label for="personaID">Selecciona Persona:</label>
            <select name="personaID" class="form-control" required>
                <?php foreach ($personas as $persona) {
                    echo "<option value='{$persona['personaID']}'>{$persona['nombre']} {$persona['apellido']}</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_rol">Selecciona Rol:</label>
            <select name="id_rol" class="form-control" required>
                <?php foreach ($roles as $rol) {
                    echo "<option value='{$rol['id_rol']}'>{$rol['rol_desc']}</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Id_maestra">Selecciona Maestra:</label>
            <select name="Id_maestra" class="form-control" required>
                <?php foreach ($maestras as $maestra) {
                    echo "<option value='{$maestra['Id']}'>{$maestra['nombre']}</option>";
                } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
</body>
</html>