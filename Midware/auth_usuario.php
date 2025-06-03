<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'Usuario') {
    header("Location: ../login.php");
    exit();
}