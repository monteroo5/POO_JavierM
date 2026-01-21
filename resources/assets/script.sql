CREATE DATABASE IF NOT EXISTS viajes_db;
USE viajes_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    dni VARCHAR(50) NOT NULL UNIQUE,
    edad INT NOT NULL,
    salario FLOAT NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS pasajeros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
    num_asiento INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Contraseña para el Admin: 'Admin123' (ya encriptada para que funcione el login)
INSERT INTO usuarios (nombre, dni, edad, salario, email, password)
VALUES ('Admin', '12345678A', 30, 2500.0, 'admin@viajes.com', '$2y$10$7R9i6lz79S8pQW0S2y3pGe.K1hB7bT0y5K8N1/mIuX1L9p5Y8z5K6');

INSERT INTO pasajeros (id_usuario, num_asiento)
VALUES (1, 42);