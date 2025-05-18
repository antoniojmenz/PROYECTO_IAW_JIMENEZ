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
    <style>
        body { font-family: Arial, sans-serif; 
            background: #f0f4f8; 
            margin: 0; 
            padding: 0; }

        header { background-color: #0077b6; 
            color: white; 
            padding: 15px 0; 
            text-align: center; }

        main { max-width: 900px; 
            margin: 20px auto; 
            background: #fff; 
            padding: 20px 30px; 
            border-radius: 10px; 
            box-shadow: 0 0 10px #ccc; }

        footer { text-align: center; 
            padding: 20px; 
            background: #caf0f8; 
            color: #03045e; 
            margin-top: 40px; 
            font-size: 0.9em; }

        label {
            display: block;
            margin: 15px 0 6px;
            font-weight: 600;
            color: #023e8a;
        }
        select {
            width: 100%;
            padding: 10px 12px;
            border: 1.8px solid #0077b6;
            border-radius: 6px;
            font-size: 1em;
            background: #e0f0ff;
            transition: border-color 0.3s ease;
            outline: none;
            cursor: pointer;
        }
        select:focus {
            border-color: #023e8a;
            background: #fff;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #0077b6;
            color: white;
            font-size: 1.1em;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #023e8a;
        }
        .mensaje {
            color: #b00020;
            font-weight: 600;
            margin: 15px 0;
            text-align: center;
        }
        nav ul { list-style: none; padding: 0; margin: 0 0 15px 0; text-align: center; }
        nav li { display: inline-block; margin: 0 15px; }
        nav a { color: #023e8a; font-weight: bold; text-decoration: none; font-size: 1.1em; }
        nav a:hover { text-decoration: underline; }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>
<body>

<header>
    <h1>Registrar Contratación</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="contrataciones.php">Contrataciones</a></li>
            <li><a href="usuarios.php">Ver usuarios</a></li>
        </ul>
    </nav>
</header>
   
<main>
    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <?php if ($usuarios->num_rows === 0): ?>
        <p class="mensaje">Todos los usuarios ya tienen una tarifa contratada.</p>
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

            <button type="submit">Registrar Contratación</button>
        </form>
    <?php endif; ?>
</main>
<footer>
<p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
</footer>

</body>
</html>

<?php $conexion->close(); ?>

