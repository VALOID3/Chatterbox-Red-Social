<?php
session_start();
include '../conexion.php'; // Ajusta la ruta si es necesario

header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit();
}

$remitente_id = $_SESSION['usuario_id'];
$destinatario_id = $_POST['destinatario_id'] ?? null;
$mensaje_texto = $_POST['mensaje_texto'] ?? '';

// Validar datos de entrada
if (!$destinatario_id || empty($mensaje_texto)) {
    echo json_encode(['success' => false, 'message' => 'ID de destinatario o mensaje vacío.']);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO mensajes (remitente_id, destinatario_id, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $remitente_id, $destinatario_id, $mensaje_texto);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje.']);
    }
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    // Log del error para depuración (en un entorno de producción, no muestres esto al usuario)
    error_log("Error en send_message.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor.']);
}

$conn->close();
?>