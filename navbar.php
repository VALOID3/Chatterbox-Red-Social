<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHATTERBOX</title>
    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/switch.css">

    <!-- ES PARA LA ANIMACION DE LOS BOTONES -->
    <link rel="stylesheet" href="css/icons.css">
    <!-- BOOTSTRAMP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a>
                <img src="images/CHATTERBOX_LONG.png" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <div class="container-navbuttons">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <!-- BOTONES QUE SOLO SE MUESTRAN CON SESIÓN -->
                        <button class="Btn" onclick="window.top.location.href='dashboard.php'">
                            <div class="sign">
                                <i class="bi bi-house-door-fill icon-large"></i>
                            </div>
                            <div class="text">INICIO</div>
                        </button>

                        <button class="Btn" onclick="window.top.location.href='perfil.php'">
                            <div class="sign">
                                <i class="bi bi-person-circle icon-large"></i>
                            </div>
                            <div class="text">PERFIL</div>
                        </button>

                        <button class="Btn" onclick="window.top.location.href='chat.php'">
                            <div class="sign">
                                <i class="bi bi-chat-dots-fill icon-large"></i>
                            </div>
                            <div class="text">CHAT</div>
                        </button>

                        <button class="Btn" onclick="window.top.location.href='busqueda.php'">
                            <div class="sign">
                                <i class="bi bi-search icon-large"></i>
                            </div>
                            <div class="text">BUSCAR</div>
                        </button>

                        <!-- <button class="Btn" onclick="window.top.location.href='login.php'">
                        <div class="sign">
                            <i class="bi bi-box-arrow-in-right icon-large"></i>
                        </div>
                        <div class="text">LOGIN</div>
                    </button> -->

                    <?php endif; ?>

                    <?php if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_rol'] === 'Admin'): ?>
                        <!-- BOTÓN DE ADMIN  -->
                        <button class="Btn" onclick="window.top.location.href='admin/dashboardAdmin.php'">
                            <div class="sign">
                                <i class="bi bi-briefcase-fill icon-large"></i>
                            </div>
                            <div class="text">ADMIN</div>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="move">
                <!-- From Uiverse.io by satyamchaudharydev -->
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>
        </div>
    </nav>

</body>

</html>