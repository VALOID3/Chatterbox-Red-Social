<?php
session_start();
header('Content-Type: application/json');

// --- CAMBIO CRÍTICO AQUÍ: La ruta correcta para la conexión ---
// Los dos puntos (..) significan "subir un nivel en el directorio"
require_once '../conexion.php'; 

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$descripcion = $_POST['contenido'] ?? '';

if (empty($descripcion)) {
    echo json_encode(['success' => false, 'message' => 'La descripción no puede estar vacía']);
    exit;
}

if (!isset($_FILES['media']) || $_FILES['media']['error'] !== 0) {
    echo json_encode(['success' => false, 'message' => 'Error al subir la imagen o no se seleccionó ninguna.']);
    exit;
}

$imgData = file_get_contents($_FILES['media']['tmp_name']);

$sqlPubli = "INSERT INTO Publicacion (usuario_id, contenido) VALUES (?, ?)";
$stmtPubli = $conn->prepare($sqlPubli);
$stmtPubli->bind_param("is", $usuario_id, $descripcion);

if (!$stmtPubli->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la publicación: ' . $stmtPubli->error]);
    exit;
}

$idPublicacion = $stmtPubli->insert_id;
$stmtPubli->close();

$sqlImg = "INSERT INTO Multimedia (publicacion_id, tipo, MultImagen) VALUES (?, 'imagen', ?)";
$stmtImg = $conn->prepare($sqlImg);
$stmtImg->bind_param("is", $idPublicacion, $imgData);


if (!$stmtImg->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la imagen: ' . $stmtImg->error]);
    exit;
}

$stmtImg->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Post publicado correctamente']);
?>