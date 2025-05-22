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

    // Validar si ya tiene una contratación
    $verificar = $conexion->prepare("SELECT COUNT(*) FROM contrataciones WHERE id_usuario = ?");
    $verificar->bind_param("i", $id_usuario);
    $verificar->execute();
    $verificar->bind_result($existe);
    $verificar->fetch();
    $verificar->close();

    if ($existe > 0) {
        $mensaje = "Este usuario ya tiene una tarifa contratada.";
    } elseif ($id_usuario && $id_tarifa) {
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

// Solo mostrar usuarios que aún NO tienen tarifa contratada
$usuarios = $conexion->query("
    SELECT u.id, u.nombre 
    FROM usuarios u 
    WHERE u.id NOT IN (SELECT id_usuario FROM contrataciones)
    ORDER BY u.nombre ASC
");

$tarifas = $conexion->query("SELECT id, nombre FROM tarifas ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registrar Contratación</title>
    <link rel='stylesheet' href='./estilos.css'>
    <style>
       

        
       


        
    </style>
</head>
<body>

<header class="headerregiscontra">
    <h1>Registrar Contratación</h1>
    <nav>
        <ul><br>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="contrataciones.php">Contrataciones</a></li>
            <li><a href="usuarios.php">Ver usuarios</a></li>
        </ul>
    </nav>
</header>
   
<main class="maincontra">
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <?php if ($usuarios->num_rows === 0): ?>
        <p class="mensajecontra">Todos los usuarios ya tienen una tarifa contratada.</p>
    <?php else: ?>
        <form method="POST" action="">
            <label for="id_usuario">Seleccionar Usuario:</label>
            <select name="id_usuario" id="id_usuario" required>
                <option value="">Selecciona un usuario</option>
                <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <option value="<?= $usuario['id'] ?>"><?= htmlspecialchars($usuario['nombre']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="id_tarifa">Seleccionar Tarifa:</label>
            <select name="id_tarifa" id="id_tarifa" required>
                <option value="">Selecciona una tarifa</option>
                <?php while ($tarifa = $tarifas->fetch_assoc()): ?>
                    <option value="<?= $tarifa['id'] ?>"><?= htmlspecialchars($tarifa['nombre']) ?></option>
                <?php endwhile; ?>
            </select>

            <button class ="botoncontra" type="submit">Registrar Contratación</button>
        </form>
    <?php endif; ?>
</main>
<footer>
<p>2025 | Tonifónica | Todos los derechos reservados</p>
</footer>

</body>
</html>

<?php $conexion->close(); ?>

