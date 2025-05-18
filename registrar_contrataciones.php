<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "toniweb", "ToniPass123!", "tonifonica");
$conexion->set_charset("utf8mb4");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";

// Guardar contratación
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_POST['id_usuario'];
    $id_tarifa = $_POST['id_tarifa'];

    // Validar datos básicos
    if ($id_usuario && $id_tarifa) {
        $stmt = $conexion->prepare("INSERT INTO contrataciones (id_usuario, id_tarifa) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_usuario, $id_tarifa);

        if ($stmt->execute()) {
            header("Location: contrataciones.php?mensaje=guardado");
            exit;
        } else {
            $mensaje = "Error al registrar la contratación.";
        }

        $stmt->close();
    } else {
        $mensaje = "Debes seleccionar usuario y tarifa.";
    }
}

// Obtener usuarios y tarifas para el formulario
$usuarios = $conexion->query("SELECT id, nombre FROM usuarios ORDER BY nombre ASC");
$tarifas = $conexion->query("SELECT id, nombre FROM tarifas ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Contratación</title>
    <style>
        body { font-family: Arial; background-color: #f0f4f8; padding: 20px; }
        h1 { color: #0077b6; }
        form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        label { display: block; margin: 12px 0 6px; font-weight: bold; }
        select, button { width: 100%; padding: 10px; margin-bottom: 10px; }
        .mensaje { color: red; text-align: center; }
        .volver { text-align: center; margin-top: 20px; }
        .volver a { color: #0077b6; text-decoration: none; }
        .volver a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h1>Registrar Contratación</h1>

<?php if ($mensaje): ?>
    <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="id_usuario">Seleccionar Usuario:</label>
    <select name="id_usuario" id="id_usuario" required>
        <option value="">-- Selecciona un usuario --</option>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nombre']) ?></option>
        <?php endwhile; ?>
    </select>

    <label for="id_tarifa">Seleccionar Tarifa:</label>
    <select name="id_tarifa" id="id_tarifa" required>
        <option value="">-- Selecciona una tarifa --</option>
        <?php while ($tarifa = $tarifas->fetch_assoc()): ?>
            <option value="<?= $tarifa['id'] ?>"><?= htmlspecialchars($tarifa['nombre']) ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Registrar Contratación</button>
</form>

<div class="volver">
    <a href="contrataciones.php">← Volver al listado de contrataciones</a>
</div>

</body>
</html>

<?php $conexion->close(); ?>
