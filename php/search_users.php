<?php
// php/search_users.php - VERSIÓN CORREGIDA FINAL

require_once '../conexion.php';
session_start();

// Verificamos que tanto el query como la sesión del usuario existan
if (isset($_GET['query']) && isset($_SESSION['usuario_id'])) {
    
    $id_usuario_actual = $_SESSION['usuario_id'];
    $searchTerm = $_GET['query'];
    
    // LA LÍNEA MÁS IMPORTANTE: ASEGÚRATE DE QUE "id_Usuario" ESTÉ EN EL SELECT
    $sql = "SELECT id_Usuario, nom_usuario, imagen_perfil FROM Usuarios WHERE nom_usuario LIKE ? AND id_Usuario != ?";
    
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $searchTerm . '%';
    
    $stmt->bind_param("si", $searchTerm, $id_usuario_actual);
    
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        // Asegurarnos que la imagen no esté vacía antes de codificar
        $imagen_perfil_base64 = !empty($row['imagen_perfil']) ? base64_encode($row['imagen_perfil']) : null;

        $users[] = [
            'id_Usuario' => $row['id_Usuario'], // <- ESTO ES VITAL
            'nom_usuario' => $row['nom_usuario'],
            'imagen_perfil' => $imagen_perfil_base64
        ];
    }
    echo json_encode($users);
    $stmt->close();
}
$conn->close();
?>