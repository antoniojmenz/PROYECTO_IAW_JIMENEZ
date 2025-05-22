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
</head>
<body>
    <header class="headereditar">
        <h1>Registro de usuarios</h1>
        <nav>
            <ul><br>
                <li><a href="index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>
    

    <main class="maineditar">
        <form method="POST" action="">
            <label for="nombre">Nombre completo:</label>
            <input class="inputeditar"type="text" id="nombre" name="nombre" required>

            <label for="edad">Edad:</label>
            <input class="inputeditar"type="number" id="edad" name="edad" required min="0">

            <label for="dni">DNI:</label>
            <input class="inputeditar"type="text" id="dni" name="dni" maxlength="9" required>

            <label for="telefono">Teléfono:</label>
            <input class="inputeditar"type="text" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input class="inputeditar"type="email" id="email" name="email" required>

            <button class="actualizar" type="submit">Registrar</button>

            <?php if ($mensaje): ?>
                <p class="mensajeregistrar"><?= $mensaje ?></p>
            <?php endif; ?>
        </form>
    </main>
    <footer>
    <p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
    </footer>
</body>
</html>