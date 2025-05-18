<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tarifas - Tonifónica</title>
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
       
        
.tarifas-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    padding: 40px;
}

.tarjeta {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    padding: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.tarjeta:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.tarjeta h2 {
    margin-top: 0;
    color: #023e8a;
}

.tarjeta p {
    margin: 5px 0;
    font-size: 0.95em;
}

.boton {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #00b4d8;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.boton:hover {
    background-color: #0077b6;
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
    </style>
</head>
<body>
    <header>
        <h1>Elige tu tarifa ideal</h1>
        <p>¡TONIFÓNICA tiene una tarifa para ti!</p>
        <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
        </ul>
    </nav>
    </header>
    
    <main class="tarifas-container">
        <!-- Tarifa 1 -->
        <div class="tarjeta">
            <h2>Tarifa Básica</h2>
            <p><strong>Precio:</strong> 9.99€/mes</p>
            <p><strong>Gigas:</strong> 5GB</p>
            <p><strong>Permanencia:</strong> No</p>
            <p><strong>Descripción:</strong> Ideal para uso ligero.</p>
            <a href="./registrar_usuarios.php" class="boton">Contratar</a>
        </div>

        <!-- Tarifa 2 -->
        <div class="tarjeta">
            <h2>Tarifa Joven</h2>
            <p><strong>Precio:</strong> 14.99€/mes</p>
            <p><strong>Gigas:</strong> 20GB</p>
            <p><strong>Permanencia:</strong> No</p>
            <p><strong>Descripción:</strong> Para redes sociales y streaming.</p>
            <a href="./registrar_usuarios.php" class="boton">Contratar</a>
        </div>

        <!-- Tarifa 3 -->
        <div class="tarjeta">
            <h2>Tarifa Pro</h2>
            <p><strong>Precio:</strong> 24.99€/mes</p>
            <p><strong>Gigas:</strong> 50GB</p>
            <p><strong>Permanencia:</strong> Sí</p>
            <p><strong>Descripción:</strong> Gran rendimiento y llamadas ilimitadas.</p>
            <a href="./registrar_usuarios.php" class="boton">Contratar</a>
        </div>

        <!-- Tarifa 4 -->
        <div class="tarjeta">
            <h2>Tarifa Familia</h2>
            <p><strong>Precio:</strong> 39.99€/mes</p>
            <p><strong>Gigas:</strong> 100GB (compartido)</p>
            <p><strong>Permanencia:</strong> Sí</p>
            <p><strong>Descripción:</strong> Comparte con hasta 4 líneas.</p>
            <a href="./registrar_usuarios.php" class="boton">Contratar</a>
        </div>

        <!-- Tarifa 5 -->
        <div class="tarjeta">
            <h2>Tarifa Ilimitada</h2>
            <p><strong>Precio:</strong> 49.99€/mes</p>
            <p><strong>Gigas:</strong> Ilimitados</p>
            <p><strong>Permanencia:</strong> Sí</p>
            <p><strong>Descripción:</strong> Navega sin límites y sin preocupaciones.</p>
            <a href="./registrar_usuarios.php" class="boton">Contratar</a>
        </div>

        <!-- Tarifa 6 -->
        <div class="tarjeta">
            <h2>Tarifa Prepago</h2>
            <p><strong>Precio:</strong> 7.99€/mes</p>
            <p><strong>Gigas:</strong> 4GB</p>
            <p><strong>Permanencia:</strong> No</p>
            <p><strong>Descripción:</strong> Controla tu consumo sin contratos.</p>
            <a href="./registrar_usuarios.php" class="boton">Contratar</a>
        </div>
    </main>

    <footer>
    <p>Tonifónica, tu empresa de telefonía de confianza. - Todos los derechos reservados</p>
    </footer>
</body>
</html>

