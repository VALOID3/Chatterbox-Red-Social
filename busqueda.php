<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.php");
  exit;
}

require_once 'conexion.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buscar usuarios</title>
  
  <link rel="stylesheet" href="css/background.css">
  <link rel="stylesheet" href="css/busqueda.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/footer.css">
  
  <!-- BOOTSTRAP ICONS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  
  <link rel="icon" type="image/png" href="images/CHATTERBOX.png">
</head>

<body>
  <!-- NAVBAR -->
  <iframe src="navbar.php" class="navbar-frame"></iframe>

  <!-- BODY -->
  <div class="search-container">
    <div class="search-bar">
      <input type="text" id="search-input" placeholder="Buscar usuarios..." onkeyup="searchProfiles()">
      <button class="search-btn">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>

  <!-- Resultados de búsqueda -->
  <div class="cards-container">
    <!-- Los resultados se cargarán aquí mediante JavaScript -->
  </div>

  <script src="js/busqueda.js"></script>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
  </footer>
</body>

</html>