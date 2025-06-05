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
    <title>Chat</title>

    <link rel="stylesheet" href="css/background.css">
    <link rel="stylesheet" href="css/chat.css">

    <link rel="stylesheet" href="css/iconsreverse.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="icon" type="image/png" href="images/CHATTERBOX.png">

</head>

<body>


    <iframe src="navbar.php"></iframe>
    <link rel="stylesheet" href="css/navbar.css">


    <nav class="vertical-navbar-white">
        <div class="w-100 p-3">
            <form class="search-form">
                <div class="input-group">
                    <input type="text" class="form-control" aria-label="Buscar" id="searchInput">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <ul class="nav flex-column w-100" id="userList">
            </ul>
    </nav>

    <div class="main-content">
        <div class="chat-header">
            <div class="user-info">
                <img src="images/PorfileP.png" class="user-avatar">
                <span class="user-name">Victor39</span>
            </div>
        </div>

        <div class="chat-container">
            <div class="chat-message incoming">
                <div class="message-content">
                    <p>Hola, ¿cómo estás?</p>
                    <span class="message-time">04:00 PM</span>
                </div>
            </div>
            <div class="chat-message outgoing">
                <div class="message-content">
                    <p>¡Hola!</p>
                    <span class="message-time">04:01 PM</span>
                </div>
            </div>
        </div>

        <div class="chat-input">
            <input type="text" class="form-control">
            <button class="btn btn-primary">
                <i class="bi bi-chat-dots-fill"></i>
            </button>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 CHATTERBOX | Todos los derechos reservados.</p>
    </footer>
    <link rel="stylesheet" href="css/footer.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const userList = document.getElementById('userList');

            // Function to fetch and display users
            function fetchUsers(query = '') {
                fetch(`php/search_users.php?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        userList.innerHTML = ''; // Clear current list
                        if (data.length > 0) {
                            data.forEach(user => {
                                const listItem = document.createElement('li');
                                listItem.classList.add('nav-item');
                                listItem.innerHTML = `
                                    <a class="nav-link" href="#">
                                        <img src="data:image/jpeg;base64,${user.imagen_perfil}" class="chat-icon me-2" alt="Profile Image"> ${user.nom_usuario}
                                    </a>
                                `;
                                userList.appendChild(listItem);
                            });
                        } else {
                            userList.innerHTML = '<li class="nav-item"><a class="nav-link">No users found.</a></li>';
                        }
                    })
                    .catch(error => console.error('Error fetching users:', error));
            }

            // Initial load of all users when the page loads
            fetchUsers();

            // Event listener for search input
            searchInput.addEventListener('input', function() {
                const query = this.value;
                fetchUsers(query);
            });
        });
    </script>

</body>

</html>