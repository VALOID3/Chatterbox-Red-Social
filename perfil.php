<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexion.php';

// Obtener ID del perfil a mostrar (puede ser el propio o uno visitado)
$usuario_id_perfil = $_GET['id'] ?? $_SESSION['usuario_id'];

// Consulta para obtener los datos del perfil incluyendo imágenes
$sql = "SELECT nombre, nom_usuario, correo, fecha_nacimiento, genero, descripcion, 
               imagen_perfil, img_PerfilFond 
        FROM Usuarios 
        WHERE id_Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id_perfil);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if (!$usuario) {
    header("Location: busqueda.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>

  <link rel="stylesheet" href="css/background.css">
  <link rel="stylesheet" href="css/perfil.css">

  <!-- ES PARA LOS BOTONES -->
  <link rel="stylesheet" href="css/iconsreverse.css">
  <!-- BOOTSTRAMP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

</head>


<body>

  <iframe src="navbar.php" class="navbar-frame"></iframe>
  <link rel="stylesheet" href="css/navbar.css">

  <div class="wrapper">
    <div class="form-header">
      <div class="titles">
        <div class="title-login">Perfil</div>
      </div>
    </div>

    <!-- IMAGEN DE FONDO -->
    <div class="background-picture-container">
        <?php if (!empty($usuario['img_PerfilFond'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($usuario['img_PerfilFond']) ?>" class="background-picture">
        <?php else: ?>
            <img src="images/BakgroundP.png" class="background-picture">
        <?php endif; ?>
    </div>

    <!-- IMAGEN DE PERFIL -->
    <div class="profile-picture-container">
        <?php if (!empty($usuario['imagen_perfil'])): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($usuario['imagen_perfil']) ?>" class="profile-picture">
        <?php else: ?>
            <img src="images/PorfileP.png" class="profile-picture">
        <?php endif; ?>
    </div>



    <!-- INFORMACIÓN DEL PERFIL -->
    <div class="profile-info">
      <h2 class="profile-username"><?php echo htmlspecialchars($usuario['nombre']); ?></h2>
      <p class="profile-fullname">@<?php echo htmlspecialchars($usuario['nom_usuario']); ?></p>
      <p class="profile-email"><?php echo htmlspecialchars($usuario['correo']); ?></p>
      <p class="profile-birthday">
        <?php
        $fecha = new DateTime($usuario['fecha_nacimiento']);
        echo $fecha->format('d \d\e F \d\e Y');
        ?>
      </p>
      <p class="profile-description">
        <?php
        echo $usuario['descripcion'] ? htmlspecialchars($usuario['descripcion']) : "Sin descripción";
        ?>
      </p>
    </div>


    <br>

    <p class="profile-description"></p>
    <!-- BOTONES -->
    <div class="container-navbuttons">
      <?php if ($usuario_id_perfil == $_SESSION['usuario_id']): ?>
        <!-- BOTONES PARA EL USUARIO LOGEADO (SU PROPIO PERFIL) -->
        <button class="Btn" onclick="location.href='EditarP.php'">
          <div class="sign">
            <i class="bi bi-pencil-fill"></i>
          </div>
          <div class="text">EDITAR PERFIL</div>
        </button>

        <button class="RedBtn" onclick="cerrarSesion()">
          <div class="sign">
            <i class="bi bi-door-open-fill"></i>
          </div>
          <div class="text">CERRAR SESION</div>
        </button>
      <?php else: ?>
        <!-- BOTÓN PARA PERFILES DE OTROS USUARIOS -->
        <button class="Btn" onclick="location.href='chat.php?user_id=<?php echo $usuario_id_perfil; ?>'">
          <div class="sign">
            <i class="bi bi-chat-dots-fill"></i>
          </div>
          <div class="text">MENSAJE</div>
        </button>
      <?php endif; ?>
    </div>
  </div>

  </div>

  <br>

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

  <script>
    function cerrarSesion() {
      if (confirm("¿Seguro que deseas cerrar sesión?")) {
        window.location.href = 'php/logout.php';
      }
    }
  </script>




  <script src="js/perfil.js"></script>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
  </footer>
  <link rel="stylesheet" href="css/footer.css">

</body>

</html>