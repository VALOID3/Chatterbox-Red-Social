<?php
session_start();
header('Content-Type: application/json');

// Verifica si el usuario está autenticado
if (!isset($_SESSION['id_Usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

require_once 'conexion.php'; // usa tu archivo de conexión

$usuario_id = $_SESSION['id_Usuario'];
$descripcion = $_POST['contenido'] ?? '';

// Validaciones
if (empty($descripcion)) {
    echo json_encode(['success' => false, 'message' => 'La descripción no puede estar vacía']);
    exit;
}

if (!isset($_FILES['media']) || $_FILES['media']['error'] !== 0) {
    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
    exit;
}

// Obtener datos de la imagen
$imgData = file_get_contents($_FILES['media']['tmp_name']);

// Guardar en Publicacion
$sqlPubli = "INSERT INTO Publicacion (usuario_id, contenido) VALUES (?, ?)";
$stmtPubli = $conn->prepare($sqlPubli);
$stmtPubli->bind_param("is", $usuario_id, $descripcion);

if (!$stmtPubli->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar publicación']);
    exit;
}

$idPublicacion = $stmtPubli->insert_id;
$stmtPubli->close();

// Guardar en Multimedia
$sqlImg = "INSERT INTO Multimedia (publicacion_id, tipo, MultImagen) VALUES (?, 'imagen', ?)";
$stmtImg = $conn->prepare($sqlImg);
$stmtImg->bind_param("ib", $idPublicacion, $null);
$stmtImg->send_long_data(1, $imgData);

if (!$stmtImg->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar imagen']);
    exit;
}

$stmtImg->close();

echo json_encode(['success' => true, 'message' => 'Post publicado correctamente']);
