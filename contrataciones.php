<?php
$conexion = new mysqli("localhost", "toniweb", "ToniPass123!", "tonifonica");
$conexion->set_charset("utf8mb4");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";
if (isset($_GET['mensaje']) && $_GET['mensaje'] === "guardado") {
    $mensaje = "Contratación registrada correctamente.";
}

$busqueda = "";
if (isset($_GET['busqueda']) && !empty(trim($_GET['busqueda']))) {
    $busqueda = trim($_GET['busqueda']);
    $like = "%" . $busqueda . "%";

    $stmt = $conexion->prepare("
        SELECT 
            usuarios.nombre AS nombre_usuario,
            usuarios.dni,
            tarifas.nombre AS nombre_tarifa,
            contrataciones.fecha_alta
        FROM contrataciones
        JOIN usuarios ON contrataciones.id_usuario = usuarios.id
        JOIN tarifas ON contrataciones.id_tarifa = tarifas.id
        WHERE tarifas.nombre LIKE ?
        ORDER BY contrataciones.fecha_alta DESC
    ");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $resultado = $conexion->query("
        SELECT 
            usuarios.nombre AS nombre_usuario,
            usuarios.dni,
            tarifas.nombre AS nombre_tarifa,
            contrataciones.fecha_alta
        FROM contrataciones
        JOIN usuarios ON contrataciones.id_usuario = usuarios.id
        JOIN tarifas ON contrataciones.id_tarifa = tarifas.id
        ORDER BY contrataciones.fecha_alta DESC
    ");
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Contrataciones</title>
    <link rel='stylesheet' href='./estilos.css'>
</head>
<body>

<header class="headercontrataciones">
    <h1>Contrataciones</h1>
    <nav>
        <ul><br>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="registrar_contratacion.php">Nueva contratación</a></li>
        </ul>
    </nav>
</header>

<main class="maincontrataciones">
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="GET" class="buscar">
        <input type="text" name="busqueda" placeholder="Buscar por tarifa..." value="<?= htmlspecialchars($busqueda) ?>">
        <button class="usuariosboton" type="submit">Buscar</button>
    </form>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <table>
            <tr>
                <th>Nombre del Usuario</th>
                <th>DNI</th>
                <th>Tarifa Contratada</th>
                <th>Fecha de Alta</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['nombre_usuario']) ?></td>
                    <td><?= htmlspecialchars($fila['dni']) ?></td>
                    <td><?= htmlspecialchars($fila['nombre_tarifa']) ?></td>
                    <td><?= htmlspecialchars(date("d/m/Y H:i", strtotime($fila['fecha_alta']))) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align: center; font-size: 1.1em;">No hay contrataciones registradas.</p>
    <?php endif; ?>
</main>

<footer>
<p>2025 | Tonifónica | Todos los derechos reservados</p>
</footer>

</body>
</html>

<?php
$conexion->close();
?>
