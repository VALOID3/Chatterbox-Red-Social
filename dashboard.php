<?php require_once './Midware/auth_usuario.php'; ?>
<?php require_once 'php/get_posts.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    
    <link rel="stylesheet" href="css/background.css">
    <link rel="stylesheet" href="css/dashboard.css">

    <link rel="stylesheet" href="css/iconsreverse.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

</head>

<body>

    <iframe src="navbar.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="css/navbar.css">

    <button class="create-post-btn">
        <i class="bi bi-plus-lg"></i>
        <span class="create-text">CREAR POST</span>
    </button>

    <div id="overlay" class="overlay"></div>

    <form id="create-post-form" class="create-post-container" enctype="multipart/form-data">
        <div class="form-header">
            <div class="titles">
                <div class="title-login">CREAR POST</div>
            </div>
        </div>

        <div class="post-content">
            <div class="image-preview-container">
            </div>

            <div class="post-inputs">
                <div class="input-box-big">
                    <textarea class="input-field" id="post-description"  name="contenido" required></textarea>
                    <label for="post-description" class="label">Descripción</label>
                </div>

                <input type="file" id="post-image-upload" name="media" class="post-upload" accept="image/*,video/*" hidden>
                <button type="button" class="btn-change-photo" onclick="document.getElementById('post-image-upload').click()">
                    <i class="bi bi-upload"></i>
                    Subir Archivo
                </button>

                <div class="container-navbuttons">
                    <button class="Btn" id="publish-post">
                        <div class="sign">
                            <i class="bi bi-check"></i>
                        </div>
                        <div class="text">Publicar</div>
                    </button>

                    <button class="RedBtn" id="cancel-post">
                        <div class="sign">
                            <i class="bi bi-x"></i>
                        </div>
                        <div class="text">Cancelar</div>
                    </button>
                </div>
            </div>
        </div>
    </form>



    <main class="post-container">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <div class="post-header">
                    <div class="post-author-info">
                        <?php if (!empty($post['imagen_perfil'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($post['imagen_perfil']) ?>" alt="Foto de perfil" class="author-avatar">
                        <?php else: ?>
                            <img src="images/PorfileP.png" alt="Foto de perfil" class="author-avatar"> <?php endif; ?>
                        <span class="author-name"><?= htmlspecialchars($post['nom_usuario']) ?></span>
                    </div>
                    <span class="post-time"><?= date('d M Y, H:i', strtotime($post['fecha'])) ?></span>
                </div>

                <div class="post-body">
                    <p><?= htmlspecialchars($post['contenido']) ?></p>
                </div>

                <?php if (!empty($post['MultImagen'])): ?>
                    <div class="post-image-container">
                        <?php if ($post['tipo'] === 'video'): ?>
                            <video controls class="post-video">
                                <source src="data:video/mp4;base64,<?= base64_encode($post['MultImagen']) ?>">
                                Tu navegador no soporta la etiqueta de video.
                            </video>
                        <?php else: ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode($post['MultImagen']) ?>" alt="Imagen del post" class="post-image">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="post-footer">
                <?php 
                        // Determinar la clase del ícono y la clase 'liked'
                        $likedClass = $post['user_has_liked'] ? 'liked' : '';
                        $iconClass = $post['user_has_liked'] ? 'bi-heart-fill' : 'bi-heart';
                    ?>
                    <button class="footer-btn like-btn <?= $likedClass ?>" data-post-id="<?= $post['id_Publi'] ?>">
                        <i class="bi <?= $iconClass ?>"></i> 
                        <span class="like-count"><?= $post['total_likes'] ?></span>
                    </button>
                    <button class="footer-btn"><i class="bi bi-chat-dots"></i> Comentar</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No hay publicaciones para mostrar. ¡Sé el primero en publicar!</p>
    <?php endif; ?>
</main>

    <script src="js/dashboard.js"></script>

    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="css/footer.css">

</body>

</html>