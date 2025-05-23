<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "MYSQLpass";
$bd = "chatterbox";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

?>
