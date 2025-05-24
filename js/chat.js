document.addEventListener("DOMContentLoaded", function() {
    const chatContainer = document.querySelector(".chat-container");
    const messageInput = document.querySelector(".chat-input input[type='text']");
    const sendButton = document.querySelector(".chat-input button");
    const chatHeaderUserName = document.querySelector(".chat-header .user-name");
    const chatHeaderUserAvatar = document.querySelector(".chat-header .user-avatar");
    const verticalNavbar = document.querySelector(".vertical-navbar-white .nav");

    let currentChatRecipientId = null;

    // Function to scroll chat to the bottom
    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Function to load messages
    function loadMessages(recipientId) {
        if (!recipientId) return;

        currentChatRecipientId = recipientId;
        chatContainer.innerHTML = ''; // Clear previous messages

        fetch(`php/get_messages.php?destinatario_id=${recipientId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.messages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.classList.add('chat-message');
                        messageDiv.classList.add(msg.is_outgoing ? 'outgoing' : 'incoming');

                        const messageContent = document.createElement('div');
                        messageContent.classList.add('message-content');
                        messageContent.innerHTML = `<p>${msg.mensaje}</p><span class="message-time">${new Date(msg.fecha_envio).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                        
                        messageDiv.appendChild(messageContent);
                        chatContainer.appendChild(messageDiv);
                    });
                    scrollToBottom();
                } else {
                    console.error("Error loading messages:", data.message);
                    chatContainer.innerHTML = `<p class="system-message">Error al cargar mensajes: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                chatContainer.innerHTML = `<p class="system-message">Error de conexión al cargar mensajes.</p>`;
            });
    }

    // Function to send a message
    sendButton.addEventListener("click", function() {
        const messageText = messageInput.value.trim();
        if (messageText === "" || !currentChatRecipientId) {
            return;
        }

        const formData = new FormData();
        formData.append('destinatario_id', currentChatRecipientId);
        formData.append('mensaje', messageText);

        fetch('php/send_message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = ''; // Clear input field
                loadMessages(currentChatRecipientId); // Reload messages to show the new one
            } else {
                console.error("Error sending message:", data.message);
                alert("Error al enviar mensaje: " + data.message);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert("Error de conexión al enviar mensaje.");
        });
    });

    // Handle pressing Enter to send message
    messageInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent new line in input
            sendButton.click();
        }
    });

    // Function to load chat users for the sidebar
    function loadChatUsers() {
        fetch('php/get_chat_users.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    verticalNavbar.innerHTML = ''; // Clear existing users

                    // Add current user's profile to the top of the chat list for visual context
                    // This assumes you want to show your own profile at the top
                    // You might need an AJAX call to get the current user's details if not in session
                    // For now, let's just add a placeholder or rely on selecting another user.

                    if (data.users.length > 0) {
                        // Set the first user in the list as the default chat recipient
                        const firstUser = data.users[0];
                        chatHeaderUserName.textContent = firstUser.nom_usuario;
                        chatHeaderUserAvatar.src = firstUser.imagen_base64;
                        loadMessages(firstUser.id_Usuario);
                    }


                    data.users.forEach(user => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('nav-item');
                        listItem.innerHTML = `
                            <a class="nav-link" href="#" data-user-id="${user.id_Usuario}" data-user-name="${user.nom_usuario}" data-user-avatar="${user.imagen_base64}">
                                <img src="${user.imagen_base64}" class="chat-icon me-2"> ${user.nom_usuario}
                            </a>
                        `;
                        verticalNavbar.appendChild(listItem);

                        // Add click event listener to switch chats
                        listItem.querySelector('.nav-link').addEventListener('click', function(e) {
                            e.preventDefault();
                            const userId = this.dataset.userId;
                            const userName = this.dataset.userName;
                            const userAvatar = this.dataset.userAvatar;

                            chatHeaderUserName.textContent = userName;
                            chatHeaderUserAvatar.src = userAvatar;
                            loadMessages(userId);

                            // Remove active class from all and add to clicked
                            document.querySelectorAll('.vertical-navbar-white .nav-link').forEach(link => link.classList.remove('active'));
                            this.classList.add('active');
                        });
                    });
                } else {
                    console.error("Error loading chat users:", data.message);
                    verticalNavbar.innerHTML = `<li class="nav-item"><p class="nav-link">Error al cargar usuarios de chat: ${data.message}</p></li>`;
                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
                verticalNavbar.innerHTML = `<li class="nav-item"><p class="nav-link">Error de conexión al cargar usuarios.</p></li>`;
            });
    }

    // Initial load of chat users when the page loads
    loadChatUsers();

    // Set up polling for new messages (e.g., every 3 seconds)
    // Be mindful of server load with frequent polling; WebSockets are better for real-time
    setInterval(() => {
        if (currentChatRecipientId) {
            loadMessages(currentChatRecipientId);
        }
    }, 3000); // Poll every 3 seconds
});