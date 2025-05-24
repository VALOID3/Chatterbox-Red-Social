<?php
session_start();
require_once '../conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Get users with whom the current user has chatted
$sql = "SELECT DISTINCT U.id_Usuario, U.nom_usuario, U.imagen_perfil
        FROM Usuarios U
        WHERE U.id_Usuario IN (
            SELECT DISTINCT remitente_id FROM mensajes WHERE destinatario_id = ?
            UNION
            SELECT DISTINCT destinatario_id FROM mensajes WHERE remitente_id = ?
        ) AND U.id_Usuario != ? LIMIT 10"; // Limit to 10 for a basic display

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$chat_users = [];
while ($row = $result->fetch_assoc()) {
    if ($row['imagen_perfil']) {
        $row['imagen_base64'] = 'data:image/jpeg;base64,' . base64_encode($row['imagen_perfil']);
    } else {
        $row['imagen_base64'] = 'images/PorfileP.png'; // Default image if none
    }
    unset($row['imagen_perfil']);
    $chat_users[] = $row;
}

echo json_encode(['success' => true, 'users' => $chat_users]);

$stmt->close();
$conn->close();
?>