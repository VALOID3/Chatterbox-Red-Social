<?php
// php/get_messages.php

require_once '../conexion.php';
session_start();

$response = ['success' => false, 'messages' => [], 'error' => 'No se pudo procesar la solicitud.'];

if (isset($_SESSION['usuario_id']) && isset($_GET['partner_id'])) {
    $loggedInUserId = $_SESSION['usuario_id'];
    $partnerId = $_GET['partner_id'];

    // Consulta para obtener mensajes entre los dos usuarios
    $sql = "SELECT remitente_id, mensaje, fecha_envio 
            FROM mensajes 
            WHERE (remitente_id = ? AND destinatario_id = ?) 
               OR (remitente_id = ? AND destinatario_id = ?) 
            ORDER BY fecha_envio ASC";
            
    $stmt = $conn->prepare($sql);
    // Debes vincular los 4 parámetros
    $stmt->bind_param("iiii", $loggedInUserId, $partnerId, $partnerId, $loggedInUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    echo json_encode($messages);
    $stmt->close();

} else {
    echo json_encode([]); // Devolver un array vacío si no hay datos
}

$conn->close();
?>