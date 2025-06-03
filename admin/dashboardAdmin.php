<?php require_once '../Midware/auth_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../cssAdmin/dashboardAdmin.css">

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

    <!-- BOTONES -->
    <div class="button-container">
        <a href="AdminUsuarios.php" class="dashboard-button">
            <i class="bi bi-people-fill"></i>
            <span>Administrar Usuarios</span>
        </a>
        <a href="AdminPost.php" class="dashboard-button">
            <i class="bi bi-file-earmark-post"></i>
            <span>Administrar Posts</span>
        </a>
        <a href="AdminTags.php" class="dashboard-button">
            <i class="bi bi-tags-fill"></i>
            <span>Administrar Tags</span>
        </a>
    </div>

    <script src="js/dashboard.js"></script>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="../css/footer.css">

</body>

</html>