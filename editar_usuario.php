<?php
$conexion = new mysqli("localhost", "toniweb", "ToniPass123!", "tonifonica");
$conexion->set_charset("utf8mb4");
if ($conexion->connect_error) die("Error de conexión: " . $conexion->connect_error);

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de usuario no especificado.");
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $edad = intval($_POST["edad"]);
    $dni = trim($_POST["dni"]);
    $telefono = trim($_POST["telefono"]);
    $email = trim($_POST["email"]);

    if ($nombre && $edad && $dni && $telefono && $email) {
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, edad=?, dni=?, telefono=?, email=? WHERE id=?");
        $stmt->bind_param("sisssi", $nombre, $edad, $dni, $telefono, $email, $id);
        if ($stmt->execute()) {
            $stmt->close();
            $conexion->close();
            header("Location: usuarios.php?mensaje=actualizado");
            exit;
        } else {
            $mensaje = "❌ Error al actualizar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $mensaje = "⚠️ Por favor, rellena todos los campos.";
    }
}

// Obtener datos del usuario
$stmt = $conexion->prepare("SELECT nombre, edad, dni, telefono, email FROM usuarios WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

$usuario = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel='stylesheet' href='./estilos.css'>
</head>
<body>
<header class="headereditar">
    <h1>Editar usuarios</h1>
    <nav>
        <ul><br>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="usuarios.php">Usuarios</a></li>
        </ul>
    </nav>
</header>

<main class="maineditar">
    <form method="POST" action="">
        <label>Nombre completo:</label>
        <input class="inputeditar" type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label>Edad:</label>
        <input class="inputeditar"type="number" name="edad" value="<?= htmlspecialchars($usuario['edad']) ?>" required min="0">

        <label>DNI:</label>
        <input class="inputeditar"type="text" name="dni" value="<?= htmlspecialchars($usuario['dni']) ?>" maxlength="9" required>

        <label>Teléfono:</label>
        <input class="inputeditar"type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>

        <label>Email:</label>
        <input class="inputeditar"type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <button class ="actualizar" type="submit">Actualizar</button>
    </form>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
</main>
<footer>
<p>2025 | Tonifónica | Todos los derechos reservados</p>
</footer>
</body>
</html>


