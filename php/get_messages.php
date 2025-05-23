<?php
session_start();
include '../conexion.php'; // Ajusta la ruta si es necesario

header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit();
}

$current_user_id = $_SESSION['usuario_id'];
$other_user_id = $_GET['other_user_id'] ?? null; // El ID del usuario con el que se está chateando

if (!$other_user_id) {
    echo json_encode(['success' => false, 'message' => 'ID del otro usuario no especificado.']);
    exit();
}

$messages = [];

try {
    // Seleccionar mensajes de la conversación entre los dos usuarios
    // (remitente=actual y destinatario=otro) OR (remitente=otro y destinatario=actual)
    // Se une con la tabla Usuarios para obtener el nombre del remitente
    $stmt = $conn->prepare("
        SELECT m.mensaje, m.fecha_envio, u.nom_usuario AS sender_username, m.remitente_id
        FROM mensajes m
        JOIN Usuarios u ON m.remitente_id = u.id_Usuario
        WHERE (m.remitente_id = ? AND m.destinatario_id = ?) OR (m.remitente_id = ? AND m.destinatario_id = ?)
        ORDER BY m.fecha_envio ASC
    ");
    $stmt->bind_param("iiii", $current_user_id, $other_user_id, $other_user_id, $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode(['success' => true, 'messages' => $messages, 'current_user_id' => $current_user_id]);
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log("Error en get_messages.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor.']);
}

$conn->close();
?>