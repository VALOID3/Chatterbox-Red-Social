<?php
require_once './Midware/auth_usuario.php';

require_once 'conexion.php';

// Obtener ID del perfil a mostrar (puede ser el propio o uno visitado)
$usuario_id_perfil = $_GET['id'] ?? $_SESSION['usuario_id'];

// Consulta para obtener los datos del perfil incluyendo imágenes
$sql = "SELECT nombre, nom_usuario, correo, fecha_nacimiento, genero, descripcion, 
               imagen_perfil, img_PerfilFond, nota, nota_timestamp
        FROM Usuarios 
        WHERE id_Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id_perfil);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

$nota_visible = null;
if (!empty($usuario['nota']) && !empty($usuario['nota_timestamp'])) {
  $fecha_nota = new DateTime($usuario['nota_timestamp']);
  $fecha_actual = new DateTime();
  $diferencia = $fecha_actual->getTimestamp() - $fecha_nota->getTimestamp();

  // La nota es visible si tiene menos de 24 horas (86400 segundos)
  if ($diferencia < 86400) {
    $nota_visible = $usuario['nota'];
  }
}

if (!$usuario) {
  header("Location: busqueda.php");
  exit;
}

// --- MODIFICADO --- Se añade m.tipo a la consulta para diferenciar entre imagen y video.
$sql_publicaciones = "SELECT p.id_Publi, p.contenido, m.MultImagen, m.tipo, p.fecha 
                      FROM Publicacion p
                      LEFT JOIN Multimedia m ON p.id_Publi = m.publicacion_id
                      WHERE p.usuario_id = ? AND m.id_Multi IS NOT NULL
                      ORDER BY p.fecha DESC";
$stmt_publicaciones = $conn->prepare($sql_publicaciones);
$stmt_publicaciones->bind_param("i", $usuario_id_perfil);
$stmt_publicaciones->execute();
$resultado_publicaciones = $stmt_publicaciones->get_result();
$publicaciones = $resultado_publicaciones->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>

  <link rel="stylesheet" href="css/background.css">
  <link rel="stylesheet" href="css/perfil.css">

  <link rel="stylesheet" href="css/iconsreverse.css">
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

    <div class="background-picture-container">
      <?php if (!empty($usuario['img_PerfilFond'])): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($usuario['img_PerfilFond']) ?>" class="background-picture">
      <?php else: ?>
        <img src="images/BakgroundP.png" class="background-picture">
      <?php endif; ?>
    </div>

    <div class="profile-picture-container">
      <?php if (!empty($usuario['imagen_perfil'])): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($usuario['imagen_perfil']) ?>" class="profile-picture">
      <?php else: ?>
        <img src="images/PorfileP.png" class="profile-picture">
      <?php endif; ?>
    </div>



    <div class="profile-info">
      <h2 class="profile-username"><?php echo htmlspecialchars($usuario['nombre']); ?></h2>
      <p class="profile-fullname">@<?php echo htmlspecialchars($usuario['nom_usuario']); ?></p>
      <div class="profile-note-container">
        <?php if ($nota_visible): ?>
          <div class="profile-note" id="display-note"><?php echo htmlspecialchars($nota_visible); ?></div>
        <?php else: ?>
          <div class="profile-note" id="display-note" style="display: none;"></div>
        <?php endif; ?>

        <?php if ($usuario_id_perfil == $_SESSION['usuario_id']): ?>
          <div id="edit-note-form" style="display:none;">
            <input type="text" id="note-input" maxlength="60" placeholder="Escribe tu nota...">
            <button id="save-note-btn">Guardar</button>
            <button id="cancel-note-btn">Cancelar</button>
          </div>
          <button class="Btn" id="edit-note-btn" style="margin-top: 10px;">
            <div class="sign"><i class="bi bi-sticky-fill"></i></div>
            <div class="text"><?php echo $nota_visible ? 'EDITAR NOTA' : 'AÑADIR NOTA'; ?></div>
          </button>
        <?php endif; ?>
      </div>
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
    <div class="container-navbuttons">
      <?php if ($usuario_id_perfil == $_SESSION['usuario_id']): ?>
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

  <div class="post-container">

    <?php if (!empty($publicaciones)): ?>
      <?php foreach ($publicaciones as $publicacion): ?>
        <div class="post"
          data-post-id="<?= $publicacion['id_Publi'] ?>"
          data-post-content="<?= htmlspecialchars($publicacion['contenido']) ?>"
          data-owner-name="<?= htmlspecialchars($usuario['nombre']) ?>"
          data-owner-pic="<?= !empty($usuario['imagen_perfil']) ? 'data:image/jpeg;base64,' . base64_encode($usuario['imagen_perfil']) : 'images/PorfileP.png' ?>"
          data-media-type="<?= $publicacion['tipo'] ?>"
          data-media-base64="<?= base64_encode($publicacion['MultImagen']) ?>">

          <?php if ($publicacion['tipo'] === 'video'): ?>
            <video class="post-video" muted>
              <source src="data:video/mp4;base64,<?= base64_encode($publicacion['MultImagen']) ?>">
            </video>
          <?php else: ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($publicacion['MultImagen']) ?>" class="post-image">
          <?php endif; ?>

        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="color: white; text-align: center; width: 100%; margin-top: 20px;">Este usuario aún no ha realizado ninguna publicación.</p>
    <?php endif; ?>

  </div>


  <div id="postFull" class="Full">
    <div class="Full-content">
      <span class="close-Full">&times;</span>
      <div class="Full-grid">

        <div class="Full-image">
        </div>
        <div class="Full-info">
          <div class="post-owner">
            <img src="images/PorfileP.png" class="owner-picture">
            <span class="owner-name"></span>
          </div>
          <p class="post-description"></p>


          <div class="Full-buttons">

            <a href="#" id="download-link" download="Chatterbox-Post.jpg" style="text-decoration: none;">
              <button class="download-btn">
                <i class="bi bi-download"></i>
              </button>
            </a>

            <?php if ($usuario_id_perfil == $_SESSION['usuario_id']): ?>
              <button class="edit-post-btn">
                <i class="bi bi-pencil"></i>
              </button>
            <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="edit-post-form" class="edit-post-container">
    <div class="edit-post-content">
      <div class="edit-post-grid">
        <div class="edit-post-image">
          <img id="edit-post-preview" src="">
        </div>
        <div class="edit-post-info">
          <div class="input-box-big">
            <label for="edit-post-desc" class="label2">DESCRIPCION</label>
            <textarea class="input-field2" id="edit-post-desc" required></textarea>
          </div>
        </div>
        <div class="edit-post-buttons">
          <button class="edit-post-delete">
            <i class="bi bi-trash"></i>
          </button>
          <button class="edit-post-discard">
            <i class="bi bi-x"></i>
          </button>
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

  <footer class="footer">
    <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
  </footer>
  <link rel="stylesheet" href="css/footer.css">

</body>

</html>