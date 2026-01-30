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
  <title>Likes</title>

  <link rel="stylesheet" href="css/background.css">
  <link rel="stylesheet" href="css/likes.css">

  <!-- ES PARA LOS BOTONES -->
  <link rel="stylesheet" href="css/iconsreverse.css">
  <!-- BOOTSTRAMP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

</head>


<body>

  <iframe src="navbar.php" class="navbar-frame"></iframe>
  <link rel="stylesheet" href="css/navbar.css">
}

  <!-- SECCIÓN DE PUBLICACIONES -->
  <div class="post-container">

    <div class="post">
      <img src="images/PUBLICACION.png" class="post-image">
    </div>

    <div class="post">
      <img src="images/PUBLICACION.png" class="post-image">
    </div>

    <div class="post">
      <img src="images/PUBLICACION.png" class="post-image">
    </div>

    <div class="post">
      <img src="images/PUBLICACION.png" class="post-image">
    </div>

    <div class="post">
      <img src="images/PUBLICACION.png" class="post-image">
    </div>

    <div class="post">
      <img src="images/PUBLICACION.png" class="post-image">
    </div>
  </div>


  <!-- FULL POST -->
  <div id="postFull" class="Full">
    <div class="Full-content">
      <span class="close-Full">&times;</span>
      <div class="Full-grid">

        <div class="Full-image">
          <img id="FullPostImage">
        </div>
        <!-- INFO DEL POST -->
        <div class="Full-info">
          <div class="post-owner">
            <img src="images/PorfileP.png" class="owner-picture">
            <span class="owner-name">Pedro Pascal</span>
          </div>
          <p class="post-description">Albion Online es un MMORPG no lineal en el que escribes tu propia historia sin
            limitarte a seguir un camino prefijado. Explora un amplio mundo abierto con cinco biomas únicos. Todo cuanto
            hagas tendrá repercusión en el mundo.</p>


          <!-- BOTON DE LIKE Y DESCARGA -->

          <div class="Full-buttons">
            <button class="like-btn">
              <i class="bi bi-heart"></i>
            </button>
            <button class="download-btn">
              <i class="bi bi-download"></i>
            </button>
            <button class="edit-post-btn">
              <i class="bi bi-pencil"></i>
            </button>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTENEDOR PARA EDITAR PUBLICACIÓN -->
  <div id="edit-post-form" class="edit-post-container">
    <div class="edit-post-content">


      <div class="edit-post-grid">
        <!-- IMAGEN -->
        <div class="edit-post-image">
          <img id="edit-post-preview" src="">
        </div>

        <!-- INFO -->
        <div class="edit-post-info">
          <div class="input-box-big">
            <label for="edit-post-desc" class="label2">DESCRIPCION</label>
            <textarea class="input-field2" id="edit-post-desc" required></textarea>
          </div>
        </div>

        <!-- BOTONES -->
        <div class="edit-post-buttons">

          <button class="edit-post-delete">
            <i class="bi bi-trash"></i>
          </button>

          </button>
          <button class="edit-post-discard">
            <i class="bi bi-x"></i>


            <button class="edit-post-save">
              <i class="bi bi-check"></i>

            </button>

        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="js/perfil.js"></script>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 CHATTERBOX | Todos los derechos reservados.</p>
  </footer>
  <link rel="stylesheet" href="css/footer.css">

</body>

</html>