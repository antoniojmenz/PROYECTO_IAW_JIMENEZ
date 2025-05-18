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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        main {
            max-width: 500px;
            background: #fff;
            margin: 40px auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            animation: fadeIn 1s ease-in;
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
        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #023e8a;
        }
        input[type="text"], input[type="number"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="email"]:focus {
            border-color: #0077b6;
            outline: none;
        }
        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #0077b6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 700;
        }
        button:hover {
            background-color: #023e8a;
        }
        .mensaje {
            margin-top: 20px;
            font-weight: bold;
            color: red;
            text-align: center;
        }
        p.volver {
            margin-top: 30px;
            text-align: center;
        }
        p.volver a {
            color: #0077b6;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        p.volver a:hover {
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
    <h1>Editar usuarios</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="usuarios.php">Usuarios</a></li>
        </ul>
    </nav>
</header>

<main>
    

    <form method="POST" action="">
        <label>Nombre completo:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label>Edad:</label>
        <input type="number" name="edad" value="<?= htmlspecialchars($usuario['edad']) ?>" required min="0">

        <label>DNI:</label>
        <input type="text" name="dni" value="<?= htmlspecialchars($usuario['dni']) ?>" maxlength="9" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <button type="submit">Actualizar</button>
    </form>

    <?php if ($mensaje): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
</main>
<footer>
    <p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
</footer>
</body>
</html>


