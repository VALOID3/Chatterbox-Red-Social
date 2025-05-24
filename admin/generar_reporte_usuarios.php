<?php
session_start();
require_once '../conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header("Location: ../login.php");
    exit();
}

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="reporte_usuarios.txt"');

// Consulta de usuarios con número de publicaciones
$sql = "
    SELECT u.id_Usuario, u.correo, u.nom_usuario, u.fecha_nacimiento, u.genero, u.rol,
           (SELECT COUNT(*) FROM Publicacion p WHERE p.usuario_id = u.id_Usuario) AS posts
    FROM Usuarios u
    ORDER BY u.id_Usuario ASC
";

$resultado = $conn->query($sql);
$total = 0;

echo "REPORTE DE USUARIOS - CHATTERBOX\n";
echo "Generado el: " . date("Y-m-d H:i:s") . "\n\n";
echo str_repeat("=", 80) . "\n";
echo "ID\tCorreo\t\tUsuario\t\tNacimiento\tGénero\t\tRol\tPosts\n";
echo str_repeat("-", 80) . "\n";

while ($row = $resultado->fetch_assoc()) {
    printf(
        "%d\t%-15s\t%-12s\t%s\t%-10s\t%-10s\t%d\n",
        $row['id_Usuario'],
        $row['correo'],
        $row['nom_usuario'],
        $row['fecha_nacimiento'],
        $row['genero'],
        $row['rol'],
        $row['posts']
    );
    $total++;
}

echo str_repeat("=", 80) . "\n";
echo "TOTAL DE USUARIOS: $total\n";

$conn->close();
exit;
