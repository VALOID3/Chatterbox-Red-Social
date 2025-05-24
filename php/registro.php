<?php
header('Content-Type: application/json');
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['name'] ?? '';
    $nom_usuario = $_POST['user'] ?? '';
    $correo = $_POST['email'] ?? '';
    $contrasena = $_POST['password'] ?? '';
    $fecha_nacimiento = $_POST['birthdate'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if (!$nombre || !$nom_usuario || !$correo || !$contrasena || !$fecha_nacimiento || !$genero) {
        echo json_encode(["success" => false, "error" => "Faltan campos"]);
        exit;
    }

    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuarios (nombre, nom_usuario, correo, contrasena, fecha_nacimiento, genero, rol)
            VALUES (?, ?, ?, ?, ?, ?, 'Administrador')";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["success" => false, "error" => "Error al preparar la consulta: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("ssssss", $nombre, $nom_usuario, $correo, $hash, $fecha_nacimiento, $genero);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}
