<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "toniweb", "ToniPass123!", "tonifonica");
$conexion->set_charset("utf8mb4");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == "eliminado") {
        $mensaje = "Usuario eliminado correctamente.";
    } elseif ($_GET['mensaje'] == "actualizado") {
        $mensaje = "Usuario actualizado correctamente.";
    }
}

$busqueda = "";
if (isset($_GET['busqueda'])) {
    $busqueda = trim($_GET['busqueda']);
    $stmt = $conexion->prepare("SELECT id, nombre, edad, dni, telefono, email FROM usuarios WHERE nombre LIKE ?");
    $like = "%" . $busqueda . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();
} else {
    $resultado = $conexion->query("SELECT id, nombre, edad, dni, telefono, email FROM usuarios");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>
    <link rel='stylesheet' href='./estilos.css'>
</head>
<body>

<header class="headerusuarios">
    <h1>Usuarios Registrados</h1>
    <nav>
        <ul><br>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="registrar_contratacion.php">Nueva contratación</a></li>
            <li><a href="registrar_usuarios.php">Registrar nuevo usuario</a></li>
        </ul>
    </nav>
</header>

<main class="mainusuarios">
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="GET">
        <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($busqueda) ?>">
        <button class="usuariosboton" type="submit">Buscar</button>
    </form>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Operación</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['edad']) ?></td>
                    <td><?= htmlspecialchars($fila['dni']) ?></td>
                    <td><?= htmlspecialchars($fila['telefono']) ?></td>
                    <td><?= htmlspecialchars($fila['email']) ?></td>
                    <td>
                        <a class="action-link" href="editar_usuario.php?id=<?= $fila['id'] ?>">Editar</a> 
                        <a class="action-link" href="eliminar_usuario.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">Borrar</a>
                    </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center; font-size: 1.1em;">No se encontraron usuarios.</p>
    <?php endif; ?>
</main>

<footer>
<p>2025 | Tonifónica | Todos los derechos reservados</p>
</footer>

</body>
</html>

<?php
if (isset($stmt)) $stmt->close();
$conexion->close();
?>



