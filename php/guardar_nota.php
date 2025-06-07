<?php
require_once '../Midware/auth_usuario.php';
require_once '../conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$nota = $data['nota'] ?? '';
$usuario_id = $_SESSION['usuario_id'];

// Validar la longitud de la nota
if (mb_strlen($nota) > 60) {
    echo json_encode(['success' => false, 'message' => 'La nota no puede exceder los 60 caracteres.']);
    exit;
}

// Si la nota está vacía, la eliminamos (ponemos a NULL)
if (empty($nota)) {
    $sql = "UPDATE Usuarios SET nota = NULL, nota_timestamp = NULL WHERE id_Usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
} else {
    // Si hay nota, la actualizamos junto con el timestamp
    $sql = "UPDATE Usuarios SET nota = ?, nota_timestamp = NOW() WHERE id_Usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nota, $usuario_id);
}


if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la nota.']);
}

$stmt->close();
$conn->close();
?>