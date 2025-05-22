-- Crear base de datos
CREATE DATABASE tonifonica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tonifonica;

-- Crear tabla de tarifas
CREATE TABLE tarifas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(5,2) NOT NULL,
    gigas INT NOT NULL,
    permanencia BOOLEAN DEFAULT 0,
    descripcion TEXT
);

-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    edad INT,
    dni VARCHAR(9) UNIQUE,
    telefono VARCHAR(15),
    email VARCHAR(100),
    fecha_registro DATE DEFAULT CURRENT_DATE,
    activo BOOLEAN DEFAULT 1
);

-- Crear tabla de contrataciones (N:M)
CREATE TABLE contrataciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_tarifa INT,
    fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_tarifa) REFERENCES tarifas(id) ON DELETE CASCADE
);

INSERT INTO tarifas (nombre, precio, gigas, permanencia, descripcion) VALUES
('Básica', 9.99, 10, 0, 'Ideal para llamadas y redes sociales.'),
('Familiar', 19.99, 50, 1, 'Comparte datos con tu familia.'),
('Ilimitada+', 24.99, 999, 1, 'Datos ilimitados para navegar sin parar.'),
('Juvenil', 12.50, 25, 0, 'Especial para jóvenes menores de 25.'),
('Prepago Mini', 6.99, 5, 0, 'Sin permanencia ni facturas.'),
('Empresarial', 34.90, 200, 1, 'Pensada para pymes y negocios.');

-- Crear usuario de MySQL para la aplicación (opcional si no usas root)
-- Este usuario tendrá permisos solo sobre esta base de datos

CREATE USER 'toniweb'@'localhost' IDENTIFIED BY 'ToniPass123!';
GRANT SELECT, INSERT, UPDATE, DELETE ON tonifonica.* TO 'toniweb'@'localhost';
FLUSH PRIVILEGES;
