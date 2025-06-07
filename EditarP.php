<?php
require_once './Midware/auth_usuario.php';

require_once 'conexion.php';

$usuario_id = $_SESSION['usuario_id'];

// Manejar subida de imágenes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar imagen de perfil
    if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] === UPLOAD_ERR_OK) {
        $imagen = file_get_contents($_FILES['profile-pic']['tmp_name']);
        $sql = "UPDATE Usuarios SET imagen_perfil = ? WHERE id_Usuario = ?";
        $stmt = $conn->prepare($sql);
        $null = null;
        $stmt->bind_param("bi", $null, $usuario_id);
        $stmt->send_long_data(0, $imagen);
        
        if ($stmt->execute()) {
            echo "<script>alert('Imagen de perfil actualizada correctamente');</script>";
        } else {
            echo "<script>alert('Error al guardar imagen de perfil: ".$conn->error."');</script>";
        }
        $stmt->close();
    }

    // Procesar imagen de fondo
    if (isset($_FILES['background-pic']) && $_FILES['background-pic']['error'] === UPLOAD_ERR_OK) {
        $imagenFondo = file_get_contents($_FILES['background-pic']['tmp_name']);
        $sql = "UPDATE Usuarios SET img_PerfilFond = ? WHERE id_Usuario = ?";
        $stmt = $conn->prepare($sql);
        $null = null;
        $stmt->bind_param("bi", $null, $usuario_id);
        $stmt->send_long_data(0, $imagenFondo);
        
        if ($stmt->execute()) {
            echo "<script>alert('Imagen de fondo actualizada correctamente');</script>";
        } else {
            echo "<script>alert('Error al guardar imagen de fondo: ".$conn->error."');</script>";
        }
        $stmt->close();
    }

    // Procesar datos del formulario principal
    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $usuario = $_POST['nom_usuario'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $descripcion = $_POST['descripcion'];

        if (!empty($contrasena)) {
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE Usuarios SET nombre = ?, nom_usuario = ?, correo = ?, contrasena = ?, descripcion = ? WHERE id_Usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nombre, $usuario, $correo, $contrasena_hash, $descripcion, $usuario_id);
        } else {
            $sql = "UPDATE Usuarios SET nombre = ?, nom_usuario = ?, correo = ?, descripcion = ? WHERE id_Usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nombre, $usuario, $correo, $descripcion, $usuario_id);
        }

        if ($stmt->execute()) {
            header("Location: perfil.php");
            exit;
        } else {
            echo "<script>alert('Error al actualizar perfil');</script>";
        }
    }
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Obtener datos del usuario incluyendo ambas imágenes
$sql = "SELECT nombre, nom_usuario, correo, descripcion, imagen_perfil, img_PerfilFond FROM Usuarios WHERE id_Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar perfil</title>
    <link rel="stylesheet" href="css/background.css">
    <link rel="stylesheet" href="css/EditarP.css">
    <link rel="stylesheet" href="css/iconsreverse.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">
</head>

<body>
    <!-- NAVBAR -->
    <iframe src="navbar.php" class="navbar-frame"></iframe>
    <link rel="stylesheet" href="css/navbar.css">

    <!-- BODY -->
    <div class="wrapper">
        <div class="form-header">
            <div class="titles">
                <div class="title-login">Editar</div>
            </div>
        </div>

        <!-- IMAGEN DE FONDO -->
        <div class="background-picture-container">
            <?php if (!empty($usuario['img_PerfilFond'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($usuario['img_PerfilFond']) ?>" class="background-picture" id="current-background-pic">
            <?php else: ?>
                <img src="images/BakgroundP.png" class="background-picture" id="current-background-pic">
            <?php endif; ?>
        </div>

        <!-- IMAGEN DE PERFIL -->
        <div class="profile-picture-container">
            <?php if (!empty($usuario['imagen_perfil'])): ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($usuario['imagen_perfil']) ?>" class="profile-picture" id="current-profile-pic">
            <?php else: ?>
                <img src="images/PorfileP.png" class="profile-picture" id="current-profile-pic">
            <?php endif; ?>
        </div>

        <div class="profile-edit">
            <!-- FORMULARIO PARA IMÁGENES -->
            <form id="image-upload-form" enctype="multipart/form-data" style="display:none;">
                <input type="file" id="profile-pic-upload" name="profile-pic" accept="image/*" hidden>
                <input type="file" id="background-pic-upload" name="background-pic" accept="image/*" hidden>
            </form>

            <!-- CONTENEDOR PARA LOS BOTONES DE CAMBIO DE IMAGEN -->
            <div class="image-buttons-container">
                <button class="btn-change-photo" onclick="document.getElementById('profile-pic-upload').click()">
                    Cambiar Foto de Perfil
                </button>
                <button class="btn-change-bg" onclick="document.getElementById('background-pic-upload').click()">
                    Cambiar Imagen de Fondo
                </button>
            </div>

            <!-- FORMULARIO PRINCIPAL -->
            <form method="POST" class="form-editar-perfil">
                <!-- USUARIO -->
                <div class="input-box">
                    <input type="text" class="input-field" id="profile-username" name="nom_usuario" value="<?= htmlspecialchars($usuario['nom_usuario']) ?>" required>
                    <label for="profile-username" class="label">Usuario</label>
                    <i class='bx bx-user icon'></i>
                </div>

                <!-- NOMBRE -->
                <div class="input-box">
                    <input type="text" class="input-field" id="profile-fullname" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
                    <label for="profile-fullname" class="label">Nombre</label>
                    <i class='bx bx-user-pin icon'></i>
                </div>

                <!-- EMAIL -->
                <div class="input-box">
                    <input type="email" class="input-field" id="profile-email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
                    <label for="profile-email" class="label">Email</label>
                    <i class='bx bx-envelope icon'></i>
                </div>

                <!-- CONTRASEÑA -->
                <div class="input-box">
                    <input type="password" class="input-field" id="profile-password" name="contrasena">
                    <label for="profile-password" class="label">Contraseña</label>
                    <i class='bx bx-lock-alt icon'></i>
                </div>

                <!-- DESCRIPCIÓN -->
                <div class="input-box-big">
                    <input type="text" class="input-field" id="profile-description" name="descripcion" value="<?= htmlspecialchars($usuario['descripcion'] ?? '') ?>">
                    <label for="profile-description" class="label">Descripción</label>
                    <i class='bx bx-comment-detail icon'></i>
                </div>

                <!-- BOTONES -->
                <div class="container-navbuttons">
                    <button type="submit" class="Btn">
                        <div class="sign">
                            <i class="bi bi-check"></i>
                        </div>
                        <div class="text">GUARDAR</div>
                    </button>
                    <button type="button" class="RedBtn" onclick="location.href='perfil.php'">
                        <div class="sign">
                            <i class="bi bi-x"></i>
                        </div>
                        <div class="text">CANCELAR</div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="css/footer.css">

    <script src="js/EditarP.js"></script>
</body>
</html>