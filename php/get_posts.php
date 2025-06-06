<?php
// php/get_posts.php

// Necesitamos la sesión para saber quién es el usuario actual
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../conexion.php';

$current_user_id = $_SESSION['usuario_id'] ?? 0;
$posts = [];

// Consulta SQL actualizada para incluir el conteo de likes y si el usuario actual le dio like
$sql = "
    SELECT
        p.id_Publi,
        p.contenido,
        p.fecha,
        u.nom_usuario,
        u.imagen_perfil,
        m.MultImagen,
        (SELECT COUNT(*) FROM likes WHERE publicacion_id = p.id_Publi) AS total_likes,
        (SELECT COUNT(*) FROM likes WHERE publicacion_id = p.id_Publi AND usuario_id = ?) > 0 AS user_has_liked
    FROM
        Publicacion AS p
    JOIN
        Usuarios AS u ON p.usuario_id = u.id_Usuario
    LEFT JOIN
        Multimedia AS m ON p.id_Publi = m.publicacion_id
    ORDER BY
        p.fecha DESC
";

// Usamos una sentencia preparada para la seguridad
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Vinculamos el ID del usuario actual a la subconsulta
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $posts = $result->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// No cerramos la conexión aquí, ya que dashboard.php podría usarla.
?>