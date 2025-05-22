<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tonifónica | Bienvenido</title>
    <link rel='stylesheet' href='./estilos.css'>
</head>
<body>
    <header>
    <img src="logo4.png"
			alt="logo tonifónica"
			width="190"
			height="160"
			title="logo tonifónica"/>
    <a href="login.php" class="boton" style="position: absolute; top: 20px; right: 20px;">Cerrar sesión</a>

    </header>
<div class='contenedor'>
    <main class="index">
            <section class="intro">
                <h2>Bienvenido a Tonifónica</h2><br>
                <p>Tu compañía telefónica de confianza.</p>
                <p>Consulta nuestras tarifas, regístrate y contrata la que más se ajuste a ti.</p>
            </section>
          
            <section class="cards">
                <article class="card">
                    <h3>TARIFAS</h3>
                    <p>Explora nuestras tarifas móviles con gigas ilimitados, llamadas y más.</p>
                    <a href="./tarifas.php" class="boton">Tarifas</a>
                </article>

                <article class="card">
                    <h3>USUARIOS</h3>
                    <p>Gestiona la información de los usuarios registrados en nuestro sistema.</p>
                    <a href="./usuarios.php" class="boton">Usuarios</a>
                </article>

                <article class="card">
                    <h3>CONTRATACIONES</h3>
                    <p>Consulta qué usuarios han contratado cada tarifa y sus detalles.</p>
                    <a href="./contrataciones.php" class="boton">Contrataciones</a>
                </article>
            </section>
    </main>
    <aside>
             <h3>¡Únete a Tonifónica!</h3>
            <div class="carrusel">
                <img src="foto1.png" alt="Oferta 1 de Tonifónica" class="activo">
            </div>
                <p><strong>Promoción exclusiva:</strong> 
                <p>&#8658 3 meses al 50% para nuevos clientes.</p>
                <p>&#8658 Atención al cliente 24/7.</p>
                <p>&#8658 Fibra y móvil sin permanencia.</p>
    </aside>
</div>
    <footer>
    <p>2025 | Tonifónica | Todos los derechos reservados</p>
    </footer>
</body>
</html>

