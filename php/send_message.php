<?php
// php/send_message.php - VERSIÓN FINAL FUNCIONAL

// INICIAMOS LA SESIÓN ANTES QUE CUALQUIER OTRA COSA.
session_start();

// Requerimos la conexión.
require_once '../conexion.php';

// Suprimimos la visualización de errores de PHP para garantizar una respuesta JSON limpia.
ini_set('display_errors', 0);
error_reporting(0);

// Preparamos una respuesta por defecto.
$response = ['success' => false, 'error' => 'Ocurrió un error desconocido.'];

// Verificamos todo en orden.
if (!$conn) {
    $response['error'] = 'Error: No se pudo conectar a la base de datos.';
} else if (!isset($_SESSION['usuario_id'])) {
    $response['error'] = 'Error: Sesión no válida.';
} else if (!isset($_POST['receiver_id']) || !isset($_POST['message'])) {
    $response['error'] = 'Error: Faltan datos en la solicitud.';
} else {
    // Si todo está bien, procedemos a insertar el mensaje.
    $senderId = $_SESSION['usuario_id'];
    $receiverId = $_POST['receiver_id'];
    $message = trim($_POST['message']);

    $sql = "INSERT INTO mensajes (remitente_id, destinatario_id, mensaje) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("iis", $senderId, $receiverId, $message);
        if ($stmt->execute()) {
            $response['success'] = true;
            unset($response['error']);
        } else {
            $response['error'] = 'Error de BD al ejecutar: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['error'] = 'Error de BD al preparar: ' . $conn->error;
    }
}

$conn->close();

// Devolvemos la respuesta siempre en formato JSON.
header('Content-Type: application/json');
echo json_encode($response);
?>