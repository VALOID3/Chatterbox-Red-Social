<?php
session_start();
header('Content-Type: application/json');

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
    echo json_encode(['success' => false, 'message' => 'Error al subir el archivo o no se seleccionó ninguno.']);
    exit;
}

// --- MODIFICADO --- Se detecta el tipo de archivo (imagen o video)
$mediaData = file_get_contents($_FILES['media']['tmp_name']);
$mediaMimeType = $_FILES['media']['type'];
$tipo_multimedia = 'imagen'; // Valor por defecto
if (strpos($mediaMimeType, 'video') === 0) {
    $tipo_multimedia = 'video';
}

$sqlPubli = "INSERT INTO Publicacion (usuario_id, contenido) VALUES (?, ?)";
$stmtPubli = $conn->prepare($sqlPubli);
$stmtPubli->bind_param("is", $usuario_id, $descripcion);

if (!$stmtPubli->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la publicación: ' . $stmtPubli->error]);
    exit;
}

$idPublicacion = $stmtPubli->insert_id;
$stmtPubli->close();

// --- MODIFICADO --- La consulta ahora es dinámica para el tipo y usa un bind_param diferente
$sqlMulti = "INSERT INTO Multimedia (publicacion_id, tipo, MultImagen) VALUES (?, ?, ?)";
$stmtMulti = $conn->prepare($sqlMulti);
// El tipo de dato para MultImagen se maneja como string ('s') que funciona para blobs
$stmtMulti->bind_param("iss", $idPublicacion, $tipo_multimedia, $mediaData);


if (!$stmtMulti->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el archivo multimedia: ' . $stmtMulti->error]);
    exit;
}

$stmtMulti->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Post publicado correctamente']);
?>