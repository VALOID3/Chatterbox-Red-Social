<?php
// Tu archivo search_users.php corregido

require_once '../conexion.php';
session_start();

// Verificamos que tanto el query como la sesión del usuario existan
if (isset($_GET['query']) && isset($_SESSION['usuario_id'])) {
    
    // 1. <<< CAMBIO AQUÍ: Obtenemos el ID del usuario de la sesión
    $id_usuario_actual = $_SESSION['usuario_id'];
    
    $searchTerm = $_GET['query'];
    
    // 2. <<< CAMBIO AQUÍ: Modificamos la consulta SQL para excluir al usuario actual
    // Usamos "id_Usuario" que es el nombre de la columna en tu tabla, según tu archivo .sql
    $sql = "SELECT id_Usuario, nom_usuario, imagen_perfil FROM Usuarios WHERE nom_usuario LIKE ? AND id_Usuario != ?";
    
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $searchTerm . '%';
    
    // 3. <<< CAMBIO AQUÍ: Añadimos el ID del usuario actual a los parámetros
    // "si" significa que el primer ? es un String y el segundo un Integer
    $stmt->bind_param("si", $searchTerm, $id_usuario_actual);
    
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        // Asegurarnos que la imagen no esté vacía antes de codificar
        $imagen_perfil_base64 = !empty($row['imagen_perfil']) ? base64_encode($row['imagen_perfil']) : null;

        $users[] = [
            'nom_usuario' => $row['nom_usuario'],
            'imagen_perfil' => $imagen_perfil_base64
        ];
    }
    echo json_encode($users);
    $stmt->close();
}
$conn->close();
?>