<?php
require_once '../conexion.php';
session_start();

$busqueda = $_GET['q'] ?? '';
$usuario_actual_id = $_SESSION['usuario_id'] ?? 0;

// Consulta para obtener datos incluyendo el BLOB de imagen
$sql = "SELECT id_Usuario, nombre, nom_usuario, imagen_perfil 
        FROM Usuarios
        WHERE (nombre LIKE ? OR nom_usuario LIKE ?)
        AND id_Usuario != ?";

$searchTerm = "%" . $busqueda . "%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $searchTerm, $searchTerm, $usuario_actual_id);
$stmt->execute();
$result = $stmt->get_result();

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    // Convertir el BLOB a base64 si existe
    if ($row['imagen_perfil']) {
        $row['imagen_base64'] = 'data:image/jpeg;base64,' . base64_encode($row['imagen_perfil']);
    } else {
        $row['imagen_base64'] = null;
    }
    unset($row['imagen_perfil']); // No necesitamos el BLOB en el JSON
    
    $usuarios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($usuarios);

$stmt->close();
$conn->close();
?>