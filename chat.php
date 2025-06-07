<?php
require_once './Midware/auth_usuario.php';

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
    <div class="chat-header" id="chatHeader"> 
        <div class="user-info">
            <img src="images/CHATTERBOX.png" class="user-avatar">
            <span class="user-name">Selecciona un chat</span>
        </div>
    </div>

    <div class="chat-container" id="chatContainer">
        <p class="text-center mt-5">¡Bienvenido! Inicia una conversación.</p>
    </div>

    <div class="chat-input">
        <form id="sendMessageForm" class="d-flex w-100">
            <input type="text" class="form-control" id="messageInput" placeholder="Escribe un mensaje..." autocomplete="off" disabled>
            <button type="submit" class="btn btn-primary" disabled>
                <i class="bi bi-chat-dots-fill"></i>
            </button>
        </form>
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
    const chatHeader = document.getElementById('chatHeader');
    const chatContainer = document.getElementById('chatContainer');
    const sendMessageForm = document.getElementById('sendMessageForm');
    const messageInput = document.getElementById('messageInput');

    // ID del usuario logueado (lo obtenemos desde la sesión de PHP)
    const loggedInUserId = <?php echo $_SESSION['usuario_id']; ?>;
    let currentChatPartnerId = null; // ID del usuario con quien se está chateando

    // --- 1. FUNCIÓN PARA BUSCAR Y MOSTRAR USUARIOS ---
    function fetchUsers(query = '') {
        fetch(`php/search_users.php?query=${query}`)
            .then(response => response.json())
            .then(data => {
                userList.innerHTML = ''; // Limpiar lista actual
                if (data.length > 0) {
                    data.forEach(user => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('nav-item');
                        // Usamos data-attributes para guardar el ID y nombre del usuario
                        listItem.innerHTML = `
                            <a class="nav-link" href="#" data-userid="${user.id_Usuario}" data-username="${user.nom_usuario}" data-userimg="${user.imagen_perfil}">
                                <img src="data:image/jpeg;base64,${user.imagen_perfil}" class="chat-icon me-2" alt="Profile Image"> ${user.nom_usuario}
                            </a>
                        `;
                        userList.appendChild(listItem);
                    });
                } else {
                    userList.innerHTML = '<li class="nav-item"><a class="nav-link">No se encontraron usuarios.</a></li>';
                }
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    // --- 2. FUNCIÓN PARA CARGAR MENSAJES DE UN CHAT ---
    function fetchMessages(chatPartnerId) {
        currentChatPartnerId = chatPartnerId;
        fetch(`php/get_messages.php?partner_id=${chatPartnerId}`)
            .then(response => response.json())
            .then(messages => {
                chatContainer.innerHTML = ''; // Limpiar chat actual
                if (messages.length > 0) {
                    messages.forEach(msg => {
                        // Determinar si el mensaje es 'entrante' o 'saliente'
                        const messageClass = msg.remitente_id == loggedInUserId ? 'outgoing' : 'incoming';
                        const messageDiv = document.createElement('div');
                        messageDiv.classList.add('chat-message', messageClass);
                        messageDiv.innerHTML = `
                            <div class="message-content">
                                <p>${msg.mensaje}</p>
                                <span class="message-time">${new Date(msg.fecha_envio).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                            </div>
                        `;
                        chatContainer.appendChild(messageDiv);
                    });
                } else {
                    chatContainer.innerHTML = '<p class="text-center">No hay mensajes. ¡Sé el primero en escribir!</p>';
                }
                // Scroll hasta el último mensaje
                chatContainer.scrollTop = chatContainer.scrollHeight;
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // --- EVENT LISTENERS ---

    // Carga inicial de usuarios
    fetchUsers();

    // Listener para la barra de búsqueda
    searchInput.addEventListener('input', () => fetchUsers(searchInput.value));

    // Listener para seleccionar un usuario de la lista
    userList.addEventListener('click', function(e) {
        e.preventDefault();
        const link = e.target.closest('a');
        if (link && link.dataset.userid) {
            const userId = link.dataset.userid;
            const userName = link.dataset.username;
            const userImg = link.dataset.userimg;

            // Actualizar cabecera del chat
            chatHeader.innerHTML = `
                <div class="user-info">
                    <img src="data:image/jpeg;base64,${userImg}" class="user-avatar">
                    <span class="user-name">${userName}</span>
                </div>
            `;
            
            // Habilitar el input de mensajes
            messageInput.disabled = false;
            sendMessageForm.querySelector('button').disabled = false;

            // Cargar los mensajes con ese usuario
            fetchMessages(userId);
        }
    });

    // Listener para enviar un mensaje
    sendMessageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const messageText = messageInput.value.trim();

        if (messageText && currentChatPartnerId) {
            const formData = new FormData();
            formData.append('receiver_id', currentChatPartnerId);
            formData.append('message', messageText);

            fetch('php/send_message.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = ''; // Limpiar el input
                    fetchMessages(currentChatPartnerId); // Recargar mensajes para ver el nuevo
                } else {
                    console.error('Error sending message:', data.error);
                }
            })
            .catch(error => console.error('Error sending message:', error));
        }
    });
});
</script>

</body>

</html>