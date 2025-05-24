<?php
header('Content-Type: application/json');
session_start();
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['email'] ?? '';
    $contrasena = $_POST['password'] ?? '';

    if (!$correo || !$contrasena) {
        echo json_encode(["success" => false, "error" => "Campos incompletos"]);
        exit;
    }

    $sql = "SELECT * FROM Usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Guardar datos en la sesión
            $_SESSION['usuario_id'] = $usuario['id_Usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nom_usuario'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            echo json_encode([
                "success" => true,
                "rol" => $usuario['rol']
            ]);
            
        } else {
            echo json_encode(["success" => false, "error" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Correo no registrado"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "Método no permitido"]);
}
