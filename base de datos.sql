-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS telefonia_db;
USE telefonia_db;

-- Tabla: usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(10) NOT NULL UNIQUE,
    telefono VARCHAR(15) NOT NULL,
    direccion VARCHAR(150),
    email VARCHAR(100) UNIQUE,
    activo BOOLEAN DEFAULT TRUE,
    fecha_alta DATE DEFAULT (CURRENT_DATE),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: companias
CREATE TABLE companias (
    id_compania INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    tarifa_base DECIMAL(6,2) NOT NULL,
    cobertura ENUM('nacional', 'regional', 'internacional') NOT NULL,
    sede VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- marca de tiempo
);

-- Tabla intermedia: afiliaciones
CREATE TABLE afiliaciones (
    id_afiliacion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_compania INT NOT NULL,
    fecha_afiliacion DATE DEFAULT (CURRENT_DATE),
    estado ENUM('activa', 'cancelada', 'pendiente') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_compania) REFERENCES companias(id_compania)
        ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY uniq_afiliacion (id_usuario, id_compania)
);

-- Crear usuario para el servidor web
CREATE USER IF NOT EXISTS 'Administrador'@'localhost' IDENTIFIED BY 'Patata!1';
GRANT SELECT, INSERT, UPDATE, DELETE ON telefonia_db.* TO 'Administrador'@'localhost';
