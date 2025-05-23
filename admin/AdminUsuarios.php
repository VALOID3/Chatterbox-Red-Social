<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Usuarios</title>

    <link rel="stylesheet" href="../cssAdmin/AdminUsuarios.css">

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
            <div class="user-count">
                <span>Total de usuarios: <strong>1</strong></span>
            </div>
        </div>

        <!-- LISTA DE USUARIOS -->
        <div class="user-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Fecha de Creación</th>
                        <th>Posts Publicados</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo de fila de usuario -->
                    <tr>
                        <td>1</td>
                        <td>Pedropascal@gmail.com</td>
                        <td>Pedro Pascal</td>
                        <td>password</td>
                        <td>10/5/1975</td>
                        <td>07/03/2025</td>
                        <td>9</td>
                        <td><span class="status active">Activo</span></td>
                        <td>
                            <button class="btn-toggle-status">
                                 Desactivar
                            </button>
                        </td>
                    </tr>
                    <!-- Más filas de usuarios pueden agregarse aquí -->
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