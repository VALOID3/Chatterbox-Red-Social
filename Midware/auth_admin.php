<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'Administrador') {
    header("Location: ../login.php"); //php para la utentificacion de usuario
    exit();
}
