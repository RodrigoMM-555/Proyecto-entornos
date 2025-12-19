--Tabla para usuarios       Se añaden con el registro y se compruevan con el login
--Tablas de pistas          ¿Queremos una tabla por deporte o una tabla general?
--Tabla para reservas       Tabla que relacione usuarios y pistas con fecha y hora

CREATE DATABASE reserva_pistas;
USE reserva_pistas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE polideportivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL
);

CREATE TABLE pistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    polideportivo_id INT,
    max_personas INT CHECK (max_personas BETWEEN 1 AND 30),
    deporte VARCHAR(50) NOT NULL,
    caracteristicas TEXT,
    FOREIGN KEY (polideportivo_id) REFERENCES polideportivos(id)
);


CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    pista_id INT,
    fecha_hora DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (pista_id) REFERENCES pistas(id)
);

