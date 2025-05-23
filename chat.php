<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>

    <link rel="stylesheet" href="css/background.css">
    <link rel="stylesheet" href="css/chat.css">

    <!-- ES PARA LOS BOTONES -->
    <link rel="stylesheet" href="css/iconsreverse.css">
    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

</head>

<body>


    <!-- NAVBAR -->
    <iframe src="navbar.php"></iframe>
    <link rel="stylesheet" href="css/navbar.css">


    <!-- NAVBAR BLANCO -->
    <nav class="vertical-navbar-white">
        <div class="w-100 p-3">
            <form class="search-form">
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="Buscar">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <ul class="nav flex-column w-100">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <img src="images/PorfileP.png" class="chat-icon me-2"> Victor39
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="images/PorfileP.png" class="chat-icon me-2"> Clark
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="images/PorfileP.png" class="chat-icon me-2"> Cristian
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="images/PorfileP.png" class="chat-icon me-2"> Hermy29
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="images/PorfileP.png" class="chat-icon me-2"> PedroPascal
                </a>
            </li>
        </ul>
    </nav>

    <!-- CONTENEDOR DE CHAT -->
    <div class="main-content">
        <div class="chat-header">
            <div class="user-info">
                <img src="images/PorfileP.png" class="user-avatar">
                <span class="user-name">Victor39</span>
            </div>
        </div>

        <div class="chat-container">
            <!-- MENSAJES -->
            <div class="chat-message incoming">
                <div class="message-content">
                    <p>Hola, ¿cómo estás?</p>
                    <span class="message-time">04:00 PM</span>
                </div>
            </div>
            <div class="chat-message outgoing">
                <div class="message-content">
                    <p>¡Hola!</p>
                    <span class="message-time">04:01 PM</span>
                </div>
            </div>
        </div>

        <!-- BARRA PARA ESCRIBIR -->
        <div class="chat-input">
            <input type="text" class="form-control">
            <button class="btn btn-primary">
                <i class="bi bi-chat-dots-fill"></i>
            </button>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="css/footer.css">

</body>

</html>