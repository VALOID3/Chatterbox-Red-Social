<?php
session_start();
require_once '../conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header("Location: ../login.php");
    exit();
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="reporte_posts.txt"');

// Consulta: publicaciones + usuario + total de likes
$sql = "
    SELECT p.id_Publi, u.nom_usuario, p.contenido, p.fecha,
           (SELECT COUNT(*) FROM likes l WHERE l.publicacion_id = p.id_Publi) AS total_likes
    FROM Publicacion p
    INNER JOIN Usuarios u ON p.usuario_id = u.id_Usuario
    ORDER BY p.id_Publi ASC
";

$result = $conn->query($sql);
$totalPosts = 0;

echo "REPORTE DE PUBLICACIONES - CHATTERBOX\n";
echo "Generado el: " . date("Y-m-d H:i:s") . "\n\n";
echo str_repeat("=", 100) . "\n";
echo "ID\tUsuario\t\tFecha\t\t\tLikes\tEstado\t\tContenido\n";
echo str_repeat("-", 100) . "\n";

while ($row = $result->fetch_assoc()) {
    printf(
        "%d\t%-12s\t%s\t%d\t%s\t%s\n",
        $row['id_Publi'],
        $row['nom_usuario'],
        $row['fecha'],
        $row['total_likes'],
        'Publicado',
        substr(trim(preg_replace('/\s+/', ' ', $row['contenido'])), 0, 50) . '...'
    );
    $totalPosts++;
}

echo str_repeat("=", 100) . "\n";
echo "TOTAL DE PUBLICACIONES: $totalPosts\n";

$conn->close();
exit;
