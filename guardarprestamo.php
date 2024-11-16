<?php
session_start();
include 'conexion.php'; // Asegúrate de tener tu conexión a la base de datos

// Verifica si el usuario es admin
if ($_SESSION['rol_desc'] != 'Admin') {
    header("Location: index.php"); // Redirige si no es admin
    exit();
}

// Obtener datos del formulario
$usuario_id = $_POST['usuario_id'];
$libro_id = $_POST['libro_id'];

// Verificar si el usuario tiene préstamos pendientes
$query = "SELECT * FROM prestamos WHERE usuario_id = ? AND fecha_devolucion IS NULL";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $usuario_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    die("El usuario tiene préstamos pendientes. No se puede realizar un nuevo préstamo hasta que devuelva los libros.");
}

// Obtener la fecha actual y calcular la fecha de devolución (por ejemplo, 14 días después)
$fecha_prestamo = date('Y-m-d');
$fecha_devolucion = date('Y-m-d', strtotime('+14 days'));

// Insertar el nuevo préstamo en la base de datos
$query = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo, fecha_devolucion) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'iiss', $usuario_id, $libro_id, $fecha_prestamo, $fecha_devolucion);

if (mysqli_stmt_execute($stmt)) {
    // Marcar el libro como no disponible
    $update_query = "UPDATE libros SET disponible = FALSE WHERE id = ?";
    $update_stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($update_stmt, 'i', $libro_id);
    mysqli_stmt_execute($update_stmt);

    echo "Préstamo solicitado exitosamente. Fecha de devolución: " . $fecha_devolucion;
} else {
    echo "Error al solicitar el préstamo: " . mysqli_stmt_error($stmt);
}

// Cerrar declaraciones y conexión
mysqli_stmt_close($stmt);
mysqli_close($con);
?>