create database chatterbox;
use chatterbox;

SET SQL_SAFE_UPDATES = 0;
DELETE FROM Usuarios;
DROP TABLE IF EXISTS Multimedia;

SELECT * FROM usuarios;


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