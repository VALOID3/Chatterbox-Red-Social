<?php
// php/get_posts.php

// No necesitamos session_start() aquí si solo es para obtener datos públicos.
// Incluimos la conexión una sola vez.
require_once __DIR__ . '/../conexion.php';

// Esta será la variable que contendrá todos nuestros posts.
$posts = [];

// La consulta SQL para obtener todo lo que necesitamos.
// Usamos LEFT JOIN para que también traiga posts que no tienen imagen.
$sql = "
    SELECT
        p.id_Publi,
        p.contenido,
        p.fecha,
        u.nom_usuario,
        u.imagen_perfil,
        m.MultImagen
    FROM
        Publicacion AS p
    JOIN
        Usuarios AS u ON p.usuario_id = u.id_Usuario
    LEFT JOIN
        Multimedia AS m ON p.id_Publi = m.publicacion_id
    ORDER BY
        p.fecha DESC
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Guardamos todos los resultados en nuestro array $posts.
    $posts = $result->fetch_all(MYSQLI_ASSOC);
}
// No cerramos la conexión aquí si vamos a seguir usándola en el dashboard.
// $conn->close();
?>