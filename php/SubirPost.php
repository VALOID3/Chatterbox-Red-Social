<?php
session_start();
header('Content-Type: application/json'); // Indicar que la respuesta será JSON

require_once 'conexion.php'; // CORREGIDO: De 'concxion.php' a 'conexion.php'

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
    exit;
}

$response = ['success' => false, 'message' => ''];

$conn->begin_transaction(); // Iniciar una transacción para asegurar la atomicidad de las operaciones

try {
    $contenido = trim($_POST['contenido'] ?? ''); // Este nombre 'contenido' sí coincide con tu dashboard.js
    $usuario_id = $_SESSION['usuario_id'];
    $media_file = $_FILES['media'] ?? null; // Este nombre 'media' sí coincide con tu dashboard.js

    // Verificar si tanto el contenido como la multimedia están vacíos
    if (empty($contenido) && ($media_file === null || $media_file['error'] === UPLOAD_ERR_NO_FILE)) {
        throw new Exception('La publicación no puede estar vacía. Debes añadir una descripción o una imagen/video.');
    }

    // 1. Insertar en la tabla Publicacion
    // Tu tabla Publicacion tiene campos id_Publi, usuario_id, fecha, contenido
    $stmt_publi = $conn->prepare("INSERT INTO Publicacion (usuario_id, contenido) VALUES (?, ?)");
    if ($stmt_publi === false) {
        throw new Exception("Error al preparar la consulta de publicación: " . $conn->error);
    }
    $stmt_publi->bind_param("is", $usuario_id, $contenido);

    if (!$stmt_publi->execute()) {
        throw new Exception("Error al ejecutar la inserción de publicación: " . $stmt_publi->error);
    }

    $publicacion_id = $stmt_publi->insert_id; // Obtener el ID de la publicación recién insertada
    $stmt_publi->close();

    // 2. Si hay un archivo multimedia, insertarlo en la tabla Multimedia
    // Tu tabla Multimedia tiene campos id_Multi, publicacion_id, tipo, MultImagen
    if ($media_file && $media_file['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $media_file['tmp_name'];
        $file_type = $media_file['type'];

        // Determinar si es imagen o video
        $tipo_multimedia = '';
        if (str_starts_with($file_type, 'image/')) {
            $tipo_multimedia = 'imagen';
        } elseif (str_starts_with($file_type, 'video/')) {
            $tipo_multimedia = 'video';
        } else {
            throw new Exception("Tipo de archivo multimedia no soportado: " . $file_type);
        }

        // Leer el contenido del archivo
        $multimedia_data = file_get_contents($file_tmp_path);

        $stmt_multimedia = $conn->prepare("INSERT INTO Multimedia (publicacion_id, tipo, MultImagen) VALUES (?, ?, ?)");
        if ($stmt_multimedia === false) {
            throw new Exception("Error al preparar la consulta de multimedia: " . $conn->error);
        }
        // IMPORTANTE: Para BLOBs grandes con send_long_data, el parámetro en bind_param se setea a NULL inicialmente.
        // Y el tipo para BLOB es 'b' en bind_param.
        $null = NULL; // Variable para el parámetro BLOB
        $stmt_multimedia->bind_param("isb", $publicacion_id, $tipo_multimedia, $null);
        $stmt_multimedia->send_long_data(2, $multimedia_data); // Enviar BLOB para el tercer parámetro (índice 2)

        if (!$stmt_multimedia->execute()) {
            throw new Exception("Error al ejecutar la inserción de multimedia: " . $stmt_multimedia->error);
        }
        $stmt_multimedia->close();
    }

    $conn->commit(); // Confirmar la transacción si todo fue bien
    $response['success'] = true;
    $response['message'] = 'Post publicado exitosamente.';

} catch (Exception $e) {
    $conn->rollback(); // Revertir la transacción en caso de cualquier error
    $response['message'] = 'Error al crear la publicación: ' . $e->getMessage();
} finally {
    $conn->close();
    echo json_encode($response);
}
?>