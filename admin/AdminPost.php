<?php 
require_once '../conexion.php';
require_once '../Midware/auth_admin.php';

$sql = "
    SELECT p.id_Publi, u.nom_usuario, p.contenido, p.fecha,
           (SELECT COUNT(*) FROM likes l WHERE l.publicacion_id = p.id_Publi) AS total_likes
    FROM Publicacion p
    INNER JOIN Usuarios u ON p.usuario_id = u.id_Usuario
    ORDER BY p.id_Publi DESC
";

$resultado = $conn->query($sql);
$publicaciones = [];
$totalPosts = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $publicaciones[] = $row;
    }
    $totalPosts = count($publicaciones);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Posts</title>

    <link rel="stylesheet" href="../cssAdmin/AdminPost.css">

    <!-- ES PARA LOS BOTONES -->
    <link rel="stylesheet" href="../css/iconsreverse.css">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">
</head>

<body>

    <!-- NAVBAR -->
    <iframe src="navbarAdmin.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="../css/navbar.css">

    <!-- CONTENIDO PRINCIPAL -->
    <div class="admin-container">
        <!-- BARRA SUPERIOR -->
        <div class="admin-header">
            <div class="search-bar">
                <input type="text" class="search-input">
                <button class="search-button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="report-button">
                <form action="generar_reporte_posts.php" method="post">
                    <button type="submit" class="btn-report">
                         Generar Reporte de Publicaciones
                    </button>
                </form>
            </div>

            <h2>Lista de Publicaciones</h2>
            <div class="user-count">Total de publicaciones: <strong><?= $totalPosts ?></strong></div>
        </div>

        <!-- LISTA DE POSTS -->
        <div class="post-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>  
                        <th>Usuario</th>
                        <th>Contenido</th>
                        <th>Fecha</th>   
                        <th>Likes</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($publicaciones as $post): ?>
                    <tr>
                        <td><?= $post['id_Publi'] ?></td>
                        <td><?= htmlspecialchars($post['nom_usuario']) ?></td>
                        <td><?= htmlspecialchars($post['contenido']) ?></td>
                        <td><?= $post['fecha'] ?></td>
                        <td><?= $post['total_likes'] ?></td>
                        <td><span class="status active">Publicado</span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="../css/footer.css">

</body>

</html>