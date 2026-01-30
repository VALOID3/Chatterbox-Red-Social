<?php
require_once '../Midware/auth_admin.php';
require_once '../conexion.php';

// Consulta para obtener las publicaciones con su propietario y conteo de likes
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

$result = $conn->query($sql);
$publicaciones = [];
$totalPublicaciones = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $publicaciones[] = $row;
    }
    $totalPublicaciones = count($publicaciones);
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Posts</title>

    <link rel="stylesheet" href="../cssAdmin/AdminPost.css">

    <link rel="stylesheet" href="../css/iconsreverse.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">
</head>

<body>

    <iframe src="navbarAdmin.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="../css/navbar.css">

    <div class="admin-container">
        <div class="admin-header">
            <div class="report-button">
                <form action="generar_reporte_posts.php" method="post">
                    <button type="submit" class="btn-report">
                        <i class="bi bi-flag-fill"></i> Generar Reporte
                    </button>
                </form>
            </div>
            <div class="post-count">
                <span>Total de publicaciones: <strong><?= $totalPublicaciones ?></strong></span>
            </div>
        </div>

        <div class="post-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Propietario</th>
                        <th>Descripción</th>
                        <th>Likes</th>
                        <th>Fecha de Creación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($publicaciones)): ?>
                        <?php foreach ($publicaciones as $post): ?>
                            <tr>
                                <td><?= $post['id_Publi'] ?></td>
                                <td><?= htmlspecialchars($post['propietario']) ?></td>
                                <td><?= htmlspecialchars($post['descripcion']) ?></td>
                                <td><?= $post['likes'] ?></td>
                                <td><?= date('d/m/Y', strtotime($post['fecha_creacion'])) ?></td>
                                <td><span class="status active">Publicado</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No hay publicaciones para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="../css/footer.css">

</body>

</html>