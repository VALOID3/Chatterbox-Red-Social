create database chatterbox;
use chatterbox;

SET SQL_SAFE_UPDATES = 0;
DELETE FROM Usuarios;
DROP TABLE IF EXISTS Multimedia;

SELECT * FROM usuarios;
select * FROM comentarios;


CREATE TABLE Usuarios (
    id_Usuario INT PRIMARY KEY AUTO_INCREMENT,     
    nombre VARCHAR(255) NOT NULL,     
    nom_usuario VARCHAR(255) NOT NULL,     
    correo VARCHAR(255) UNIQUE NOT NULL,     
    contrasena VARCHAR(255) NOT NULL,     
    fecha_nacimiento DATE,     
    imagen_perfil LONGBLOB,
    img_PerfilFond LONGBLOB,
    genero ENUM('Femenino', 'Masculino', 'No binario', 'Otro') NOT NULL,     
    rol ENUM('Administrador', 'Usuario') NOT NULL,
	descripcion TEXT NULL
);

insert into usuarios(id_Usuario, nombre, nom_usuario, correo, contrasena, fecha_nacimiento, imagen_perfil, img_PerfilFond, genero, rol, descripcion, nota, nota_timestamp) values(2, "Alfredo Hernandez", "Alfred", "Alfred@hotmail.com", "199-10-03", null, null, "Masculino", "Administrador", Null, null, null);

CREATE TABLE PreferenciasUsuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    modo_oscuro BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id_Usuario) ON DELETE CASCADE,
    UNIQUE (usuario_id)
);

CREATE TABLE Publicacion (
    id_Publi INT PRIMARY KEY AUTO_INCREMENT,   
    usuario_id INT NOT NULL,           
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    contenido Text,   
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id_Usuario) ON DELETE CASCADE
);

CREATE TABLE Multimedia (
    id_Multi INT AUTO_INCREMENT PRIMARY KEY,
    publicacion_id INT NOT NULL,
    tipo ENUM('imagen', 'video') NOT NULL,
    MultImagen LONGBLOB,
    FOREIGN KEY (publicacion_id) REFERENCES Publicacion(id_Publi) ON DELETE CASCADE
);

CREATE TABLE likes (
    id_like INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    publicacion_id INT NOT NULL,
    UNIQUE (usuario_id, publicacion_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id_Usuario) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES Publicacion(id_Publi) ON DELETE CASCADE
);

CREATE TABLE reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_usuarios INT DEFAULT 0,
    total_publicaciones INT DEFAULT 0,
    fecha_generacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mensajes (
    id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
    remitente_id INT NOT NULL,
    destinatario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (remitente_id) REFERENCES Usuarios(id_Usuario) ON DELETE CASCADE,
    FOREIGN KEY (destinatario_id) REFERENCES Usuarios(id_Usuario) ON DELETE CASCADE
);

CREATE TABLE Comentarios (
    id_comentario INT AUTO_INCREMENT PRIMARY KEY,
    publicacion_id INT NOT NULL,
    usuario_id INT NOT NULL,
    contenido TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publicacion_id) REFERENCES Publicacion(id_Publi) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id_Usuario) ON DELETE CASCADE
);


ALTER TABLE Usuarios
ADD COLUMN nota VARCHAR(60) NULL DEFAULT NULL,
ADD COLUMN nota_timestamp TIMESTAMP NULL DEFAULT NULL;

select * from usuarios;
delete  from usuarios
where id_Usuario = 3;
alter table usuarios auto_increment = 0;
TRUNCATE TABLE usuarios;
TRUNCATE TABLE publicacion;
TRUNCATE TABLE comentarios;
TRUNCATE TABLE likes;
TRUNCATE TABLE mensajes;
TRUNCATE TABLE multimedia;
TRUNCATE TABLE PreferenciasUsuario;
TRUNCATE TABLE reportes;

INSERT INTO Usuarios (nombre, nom_usuario, correo, contrasena, fecha_nacimiento, genero, rol, descripcion)
VALUES ("Alfredo Hernandez", "Alfred", "alfred@example.com", "$2y$10$EjemploDeHashGenerado...", "1990-05-10", "Masculino", "Administrador", "Usuario administrador de prueba");


