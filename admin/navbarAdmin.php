<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHATTERBOX </title>
    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    


    <!-- ES PARA LA ANIMACION DE LOS BOTONES -->
    <link rel="stylesheet" href="../css/icons.css">
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
                <img src="../images/CHATTERBOX_LONG.png" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <div class="container-navbuttons">

                    <button class="Btn" onclick="window.top.location.href='dashboardAdmin.php'">
                        <div class="sign">
                            <i class="bi bi-house-door-fill icon-large"></i>
                        </div>
                        <div class="text">INICIO</div>
                    </button>

                    <button class="Btn" onclick="window.top.location.href='AdminUsuarios.php'">
                        <div class="sign">
                            <i class="bi bi-people-fill icon-large"></i>
                        </div>    
                        <div class="text">USUARIOS</div>
                    </button>

                    <button class="Btn" onclick="window.top.location.href='AdminPost.php'">
                        <div class="sign">
                            <i class="bi bi-file-earmark-post icon-large"></i>
                        </div>
                        <div class="text">POSTS</div>
                    </button>

                    <button class="Btn" onclick="window.top.location.href='AdminTags.php'">
                        <div class="sign">
                            <i class="bi bi-tags-fill icon-large"></i>
                        </div>
                        <div class="text">TAGS</div>
                    </button>

                </div>
            </div>
        </div>
    </nav>

</body>

</html>