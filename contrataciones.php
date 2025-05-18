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
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; padding: 0; }
        header { background-color: #0077b6; color: white; padding: 15px 0; text-align: center; }
        main { max-width: 900px; margin: 20px auto; background: #fff; padding: 20px 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        footer { text-align: center; padding: 20px; background: #caf0f8; color: #03045e; margin-top: 40px; font-size: 0.9em; }
        .mensaje { text-align: center; font-weight: bold; color: green; margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; background-color: #f9f9f9; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th, td { padding: 14px 12px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background-color: #0077b6; color: white; font-weight: 600; }
        tr:hover { background-color: #e0f0ff; }
        nav ul { list-style: none; padding: 0; margin: 0 0 15px 0; text-align: center; }
        nav li { display: inline-block; margin: 0 15px; }
        nav a { color: #023e8a; font-weight: bold; text-decoration: none; font-size: 1.1em; }
        nav a:hover { text-decoration: underline; }
        form.buscar {
            text-align: center;
            margin-bottom: 20px;
        }
        form.buscar input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        form.buscar input[type="text"]:focus {
            border-color: #0077b6;
            outline: none;
        }
        form.buscar button {
            padding: 10px 20px;
            background-color: #0077b6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            margin-left: 8px;
            transition: background-color 0.3s ease;
        }
        form.buscar button:hover {
            background-color: #023e8a;
        }
    </style>
</head>
<body>

<header>
    <h1>Contrataciones</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="registrar_contratacion.php">Nueva contratación</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="GET" class="buscar">
        <input type="text" name="busqueda" placeholder="Buscar por tarifa..." value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
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
<p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
</footer>

</body>
</html>

<?php
$conexion->close();
?>
