<?php
session_start();
header('Content-Type: application/json');

require_once '../conexion.php';

// 1. Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Error: Usuario no autenticado.']);
    exit;
}

// 2. Obtener los datos de la solicitud
$usuario_id = $_SESSION['usuario_id'];
$publicacion_id = $_POST['post_id'] ?? 0;

if ($publicacion_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Error: ID de publicación no válido.']);
    exit;
}

// 3. Comprobar si ya existe un "like" para este usuario y publicación
$sqlCheck = "SELECT id_like FROM likes WHERE usuario_id = ? AND publicacion_id = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("ii", $usuario_id, $publicacion_id);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

$userHasLiked = false;

if ($resultCheck->num_rows > 0) {
    // Si ya existe el like, lo eliminamos (unlike)
    $sqlDelete = "DELETE FROM likes WHERE usuario_id = ? AND publicacion_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("ii", $usuario_id, $publicacion_id);
    $stmtDelete->execute();
    $userHasLiked = false;
} else {
    // Si no existe, lo insertamos (like)
    $sqlInsert = "INSERT INTO likes (usuario_id, publicacion_id) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ii", $usuario_id, $publicacion_id);
    $stmtInsert->execute();
    $userHasLiked = true;
}

// 4. Obtener el nuevo recuento total de "likes" para la publicación
$sqlCount = "SELECT COUNT(*) AS like_count FROM likes WHERE publicacion_id = ?";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->bind_param("i", $publicacion_id);
$stmtCount->execute();
$resultCount = $stmtCount->get_result()->fetch_assoc();
$newLikeCount = $resultCount['like_count'];

// 5. Devolver una respuesta JSON al frontend
echo json_encode([
    'success' => true,
    'newLikeCount' => $newLikeCount,
    'userHasLiked' => $userHasLiked
]);

$conn->close();
?>