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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        header{
            background-color: #0077b6;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #caf0f8;
            color: #03045e;
            text-align: center;
            margin-top: 40px;
            font-size: 0.9em;
            color: #03045e;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
            text-align: center;
        }
        nav li {
            display: inline-block;
            margin: 0 15px;
        }
        nav a {
            color: #023e8a;
            font-weight: bold;
            text-decoration: none;
            font-size: 1.1em;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            animation: fadeIn 1s ease-in;
        }
        .mensaje {
            text-align:center;
            font-weight:bold;
            color: green;
            margin: 15px 0;
        }
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
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #0077b6;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background-color: #e0f0ff;
        }
        a.action-link {
            color: #0077b6;
            font-weight: 600;
            text-decoration: none;
            margin: 0 6px;
            transition: color 0.3s ease;
        }
        a.action-link:hover {
            color: #023e8a;
            text-decoration: underline;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>
<body>

<header>
    <h1>Usuarios Registrados</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="registrar_contratacion.php">Nueva contratación</a></li>
            <li><a href="registrar_usuarios.php">Registrar nuevo usuario</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="GET" class="buscar">
        <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Edad</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['edad']) ?></td>
                    <td><?= htmlspecialchars($fila['dni']) ?></td>
                    <td><?= htmlspecialchars($fila['telefono']) ?></td>
                    <td><?= htmlspecialchars($fila['email']) ?></td>
                    <td>
                        <a class="action-link" href="editar_usuario.php?id=<?= $fila['id'] ?>">Editar</a> |
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
    <p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
</footer>

</body>
</html>

<?php
if (isset($stmt)) $stmt->close();
$conexion->close();
?>



