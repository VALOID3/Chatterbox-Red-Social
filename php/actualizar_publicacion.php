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

// Validar que los datos necesarios fueron enviados
if (!isset($data['post_id']) || !isset($data['descripcion'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    exit;
}

$postId = $data['post_id'];
$descripcion = $data['descripcion'];
$usuarioId = $_SESSION['usuario_id'];

// Preparar la consulta para actualizar la publicación
// Se incluye "usuario_id = ?" como medida de seguridad para que un usuario
// no pueda modificar las publicaciones de otro.
$sql = "UPDATE Publicacion SET contenido = ? WHERE id_Publi = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sii", $descripcion, $postId, $usuarioId);
    
    if ($stmt->execute()) {
        // Verificar si alguna fila fue afectada
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Publicación actualizada correctamente.']);
        } else {
            // No se afectaron filas, puede ser porque el post no pertenece al usuario
            echo json_encode(['success' => false, 'message' => 'No se pudo actualizar la publicación o no tienes permiso.']);
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