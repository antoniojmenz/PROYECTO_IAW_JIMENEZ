<?php
$conexion = new mysqli("localhost", "toniweb", "ToniPass123!", "tonifonica");
if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de usuario no especificado.");
}

$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    $conexion->close();
    header("Location: usuarios.php?mensaje=eliminado");
    exit;
} else {
    die("Error al eliminar usuario: " . $stmt->error);
}
