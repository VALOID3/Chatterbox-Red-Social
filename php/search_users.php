<?php
require_once '../conexion.php';
session_start();

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];
    $sql = "SELECT nom_usuario, imagen_perfil FROM Usuarios WHERE nom_usuario LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'nom_usuario' => $row['nom_usuario'],
            'imagen_perfil' => base64_encode($row['imagen_perfil']) // Assuming imagen_perfil is BLOB
        ];
    }
    echo json_encode($users);
    $stmt->close();
}
$conn->close();
?>