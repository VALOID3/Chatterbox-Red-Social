<?php
session_start();
require_once '../conexion.php'; // Ajusta la ruta si es necesario

// Asegurarse de que el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Acceso denegado.']);
    exit;
}

// Obtener los datos enviados como JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validar que el ID del post fue enviado
if (!isset($data['post_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'ID de publicación no proporcionado.']);
    exit;
}

$postId = $data['post_id'];
$usuarioId = $_SESSION['usuario_id'];

// Preparar la consulta para eliminar la publicación
// Incluimos "usuario_id = ?" para asegurar que un usuario solo pueda borrar sus propios posts.
$sql = "DELETE FROM Publicacion WHERE id_Publi = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ii", $postId, $usuarioId);
    
    if ($stmt->execute()) {
        // Si se afectó al menos una fila, la eliminación fue exitosa
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Publicación eliminada correctamente.']);
        } else {
            // No se afectaron filas, probablemente porque el post no pertenece al usuario
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar la publicación o no tienes permiso.']);
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Error al ejecutar la consulta.']);
    }
    
    $stmt->close();
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta.']);
}

$conn->close();
?>