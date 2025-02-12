
CREATE DATABASE IF NOT EXISTS tareas;
USE tareas;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100)NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña  VARCHAR(255) NOT NULL
);
CREATE TABLE tarea (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario int,
    descripcion TEXT NOT NULL,
    estado ENUM ("Pendiente", "Completado") DEFAULT "Pendiente",
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON UPDATE CASCADE ON DELETE CASCADE
);

select * from usuarios;
select * from tarea;