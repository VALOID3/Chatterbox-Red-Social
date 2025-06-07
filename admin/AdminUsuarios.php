<?php

require_once '../Midware/auth_admin.php';
require_once '../conexion.php';



// Consulta usuarios con cantidad de publicaciones
$sql = "
    SELECT u.id_Usuario, u.correo, u.nom_usuario, u.contrasena, u.fecha_nacimiento, u.genero, u.rol,
           (SELECT COUNT(*) FROM Publicacion p WHERE p.usuario_id = u.id_Usuario) AS posts
    FROM Usuarios u
    ORDER BY u.id_Usuario ASC
";

$result = $conn->query($sql);
$usuarios = [];
$totalUsuarios = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    $totalUsuarios = count($usuarios);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios | Admin</title>
    <link rel="stylesheet" href="../cssAdmin/AdminUsuarios.css">
    <!-- ES PARA LOS BOTONES -->
    <link rel="stylesheet" href="../css/iconsreverse.css">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">
</head>


<body>

    <iframe src="navbarAdmin.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="../css/navbar.css">

    <div class="admin-container">
        <div class="admin-header">
            <div class="report-button">
                <form action="generar_reporte_usuarios.php" method="post">
                    <button type="submit" class="btn-report">
                        <i class="bi bi-flag-fill"></i> Reporte cantidad USUARIOS
                    </button>
                </form>
            </div>

            <h2>Lista de Usuarios</h2>
            <div class="user-count">Total de usuarios: <strong><?= $totalUsuarios ?></strong></div>
        </div>

        <div class="user-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Género</th>
                        <th>Rol</th>
                        <th>Posts Publicados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id_Usuario'] ?></td>
                            <td><?= htmlspecialchars($usuario['correo']) ?></td>
                            <td><?= htmlspecialchars($usuario['nom_usuario']) ?></td>
                            <td>••••••••</td>
                            <td><?= $usuario['fecha_nacimiento'] ?></td>
                            <td><?= $usuario['genero'] ?></td>
                            <td><?= $usuario['rol'] ?></td>
                            <td><?= $usuario['posts'] ?></td>
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