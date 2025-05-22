<?php
session_start();

$usuario_valido = "toniweb";
$contrasena_valida = "Tonipass123!";
$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"] ?? '';
    $contrasena = $_POST["contrasena"] ?? '';

    if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
        $_SESSION["usuario"] = $usuario;
        header("Location: index.php"); // Redirige a la página principal
        exit();
    } else {
        $mensaje_error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión | Tonifónica</title>
    <link rel='stylesheet' href='./estilos.css'>
</head>
<body class="cuerpo">
<div class="login-container">
    <h2>Acceso a Tonifónica</h2>
    <form method="POST" action="">
        <input class="inputacceso" type="text" name="usuario" placeholder="Usuario" required><br>
        <input class="inputacceso"type="password" name="contrasena" placeholder="Contraseña" required><br>
        <button type="submit" class="botonazul">Entrar</button>
    </form>
    <?php if ($mensaje_error): ?>
        <p class="error"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
