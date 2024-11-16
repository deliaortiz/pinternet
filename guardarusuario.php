<?php
session_start();
include 'conexion.php'; // Asegúrate de tener tu conexión a la base de datos

// Verifica si el usuario es admin
if ($_SESSION['rol_desc'] != 'Admin') {
    header("Location: index.php"); // Redirige si no es admin
    exit();
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$username = $_POST['username']; // Asegúrate de que este campo esté en tu formulario
$password = $_POST['password']; // Asegúrate de que este campo esté en tu formulario
$personaID = $_POST['personaID']; // Este campo debe estar en tu formulario

// Validar que los campos no estén vacíos
if (empty($nombre) || empty($apellido) || empty($email) || empty($username) || empty($password) || empty($personaID)) {
    die("Todos los campos son obligatorios.");
}

// Validar el formato del correo electrónico
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Formato de correo electrónico inválido.");
}

// Aquí puedes realizar la inserción en la base de datos
$query = "INSERT INTO usuarios (personaID, id_rol, username, password, Id_maestra) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $query);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . mysqli_error($con));
}

// Cambia '1' por el id_rol correspondiente si tienes un rol específico para este usuario
$id_rol = 1; // Por ejemplo, asignando rol Admin o cambia según tu lógica

mysqli_stmt_bind_param($stmt, 'iissi', $personaID, $id_rol, $username, password_hash($password, PASSWORD_DEFAULT), $Id_maestra);

if (mysqli_stmt_execute($stmt)) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error al registrar el usuario: " . mysqli_stmt_error($stmt);
}

// Cerrar declaración y conexión
mysqli_stmt_close($stmt);
mysqli_close($con);
?>