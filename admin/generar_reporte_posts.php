<?php
require_once '../Midware/auth_admin.php';
require_once '../conexion.php';

// Encabezados para forzar la descarga del archivo de texto
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="reporte_publicaciones.txt"');

// Consulta para obtener las publicaciones (la misma que en AdminPost.php)
$sql = "
    SELECT
        p.id_Publi,
        u.nom_usuario AS propietario,
        p.contenido AS descripcion,
        p.fecha AS fecha_creacion,
        (SELECT COUNT(*) FROM likes l WHERE l.publicacion_id = p.id_Publi) AS likes
    FROM
        Publicacion p
    JOIN
        Usuarios u ON p.usuario_id = u.id_Usuario
    ORDER BY
        p.id_Publi ASC
";

$resultado = $conn->query($sql);
$total = 0;

// Escribir el encabezado del reporte
echo "REPORTE DE PUBLICACIONES - CHATTERBOX\n";
echo "Generado el: " . date("Y-m-d H:i:s") . "\n\n";
echo str_repeat("=", 100) . "\n";
// Columnas del reporte
printf("%-5s | %-20s | %-6s | %-12s | %s\n", "ID", "Propietario", "Likes", "Fecha", "Contenido");
echo str_repeat("-", 100) . "\n";

// Escribir cada fila del reporte
if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $fecha = date('d/m/Y', strtotime($row['fecha_creacion']));
        // Limpiar saltos de línea en la descripción para que no rompa el formato
        $descripcion = str_replace(["\r", "\n"], ' ', $row['descripcion']);

        printf(
            "%-5d | %-20s | %-6d | %-12s | %s\n",
            $row['id_Publi'],
            htmlspecialchars($row['propietario']),
            $row['likes'],
            $fecha,
            htmlspecialchars($descripcion)
        );
        $total++;
    }
} else {
    echo "No se encontraron publicaciones.\n";
}

// Escribir el pie de página del reporte
echo str_repeat("=", 100) . "\n";
echo "TOTAL DE PUBLICACIONES: " . $total . "\n";

$conn->close();
exit;