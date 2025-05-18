<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tonifónica | Bienvenido</title>
 
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #0077b6;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            flex: 2;
            padding: 40px;
            background-color: #f0f4f8;
        }

        .intro, .cards {
            margin-bottom: 20px;
            text-align: center;
        }

        .intro h2 {
            color: #0077b6;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            margin-top: 0;
        }

        .boton {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .boton:hover {
            background-color: #023e8a;
        }

        aside {
            flex: 0.6;
            width: 100px;
            background-color:rgb(180, 234, 252);
            padding: 11px;
            padding-left: 50px;
            border-radius: 0px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        aside h3 {
            color: #0077b6;
        }

        aside p {
            font-size: 0.95em;
        }

        footer {
            text-align: center;
            padding: 15px;
            background: #caf0f8;
            font-size: 0.9em;
            color: #03045e;
        }
        aside .carrusel {
            position: relative;
            width: 83%;
            height: 193px;
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        aside .carrusel img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        aside .carrusel img.activo {
            opacity: 1;
        }
        .contenedor {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

    </style>
</head>
<body>
    <header>
    <img src="logo.png"
			alt="logo tonifónica"
			width="120"
			height="120"
			title="logo tonifónica"/>
    </header>
<div class='contenedor'>
    <main>
            <section class="intro">
                <h2>Bienvenido a Tonifónica</h2>
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
    <p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
    </footer>
</body>
</html>

