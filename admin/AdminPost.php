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
                <button class="btn-report">
                    <i class="bi bi-flag-fill"></i> Generar Reporte
                </button>
            </div>
            <div class="post-count">
                <span>Total de publicaciones: <strong>1</strong></span>
            </div>
        </div>

        <!-- LISTA DE POSTS -->
        <div class="post-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>IDM</th>
                        <th>Propietario</th>
                        <th>Descripción</th>
                        <th>Likes</th>
                        <th>Tag</th>
                        <th>Fecha de Creación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo de fila de post -->
                    <tr>
                        <td>1</td>
                        <td>09213</td>
                        <td>Pedro Pascal</td>
                        <td>    Albion Online es un MMORPG no lineal en el que escribes tu propia historia sin
                            limitarte a seguir un camino prefijado. Explora un amplio mundo abierto con cinco biomas únicos.
                            Todo cuanto
                            hagas tendrá repercusión en el mundo.</td>
                        <td>10</td>
                        <td>Videojuegos</td>
                        <td>07/03/2025</td>
                        <td><span class="status active">Activo</span></td>
                        <td>
                            <button class="btn-toggle-status">
                                Desactivar
                            </button>
                        </td>
                    </tr>
                    <!-- Más filas de posts pueden agregarse aquí -->
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