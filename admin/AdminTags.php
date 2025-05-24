<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header("Location: ../login.php"); // O la ruta que uses para tu login
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tags</title>

    <link rel="stylesheet" href="../cssAdmin/AdminTags.css">

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
                <button class="btn-report">
                    <i class="bi bi-flag-fill"></i> Generar Reporte
                </button>
            </div>
            <div class="tag-count">
                <span>Total de tags: <strong>20</strong></span>
            </div>
        </div>

        <!-- LISTA DE TAGS -->
        <div class="tag-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Posts</th>
                        <th>Nombre del Tag</th>
                        <th>Fecha de Creación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo de fila de tag -->
                    <tr>
                        <td>1</td>
                        <td>20</td>
                        <td>Videojuegos</td>
                        <td>07/03/2024</td>
                        <td><span class="status active">Activo</span></td>
                        <td>
                            <button class="btn-toggle-status">
                                Desactivar
                            </button>
                        </td>
                    </tr>
                    <!-- Más filas de tags pueden agregarse aquí -->
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