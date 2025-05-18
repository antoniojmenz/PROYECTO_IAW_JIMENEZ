<?php
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión con la base de datos
    $conexion = new mysqli("localhost", "toniweb", "ToniPass123!", "tonifonica");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Sanitizar y validar datos
    $nombre = trim(htmlspecialchars($_POST["nombre"]));
    $edad = intval($_POST["edad"]);
    $dni = trim(htmlspecialchars($_POST["dni"]));
    $telefono = trim(htmlspecialchars($_POST["telefono"]));
    $email = trim(htmlspecialchars($_POST["email"]));

    if ($nombre && $edad && $dni && $telefono && $email) {
        // Consulta preparada para evitar inyección
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, edad, dni, telefono, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $nombre, $edad, $dni, $telefono, $email);

        if ($stmt->execute()) {
            $mensaje = "✅ Usuario registrado correctamente.";
        } else {
            $mensaje = "❌ Error al registrar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $mensaje = "⚠️ Por favor, rellena todos los campos.";
    }

    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="./estilos.css">
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
        form {
            max-width: 500px;
            margin: auto;
            background: #ffffffcc;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            animation: fadeIn 1s ease-in;
        }

        input, button {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1em;
        }

        button {
            background-color: #0077b6;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #023e8a;
        }

        .mensaje {
            text-align: center;
            margin: 15px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <h1>Registro de usuarios</h1>
        <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
        </ul>
    </nav>
    </header>
    

    <main>
        <form method="POST" action="">
            <label for="nombre">Nombre completo:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="edad">Edad:</label>
            <input type="number" id="edad" name="edad" required min="0">

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" maxlength="9" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <nav>
                <ul>
                     <li><a href="registrar_contratacion.php">Seleccionar tarifa</a></li>
                </ul>
            </nav>

            <button type="submit">Registrar</button>

            <?php if ($mensaje): ?>
                <p class="mensaje"><?= $mensaje ?></p>
            <?php endif; ?>
        </form>
    </main>
    <footer>
    <p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
    </footer>
</body>
</html>