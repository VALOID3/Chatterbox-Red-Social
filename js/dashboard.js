// MUESTRA CREAR POST
document.querySelector(".create-post-btn").addEventListener("click", function () {
    document.getElementById("create-post-form").style.display = "block";
    document.getElementById("overlay").style.display = "block";
});

// BTN CANCELAR
document.getElementById("cancel-post").addEventListener("click", function (e) {
    e.preventDefault(); // Prevenir el envío del formulario
    document.getElementById("create-post-form").style.display = "none";
    document.getElementById("overlay").style.display = "none";
});

// OCULTA CREAR POST AL HACER CLIC FUERA
document.getElementById("overlay").addEventListener("click", function (event) {
    if (event.target === document.getElementById("overlay")) {
        document.getElementById("create-post-form").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }
});

// PREVISUALIZACION DE IMAGEN
document.getElementById("post-image-upload").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("post-preview").src = e.target.result;
            document.getElementById("post-preview").style.display = "block";
        };
        reader.readAsDataURL(file);
    }
});

// PUBLICAR POST
document.getElementById("create-post-form").addEventListener("submit", function(e) {
    e.preventDefault(); // Prevenir el envío tradicional del formulario
    
    const descripcion = document.getElementById("post-description").value;
    const fileInput = document.getElementById("post-image-upload");
    
    const formData = new FormData();
    formData.append('contenido', descripcion);
    
    if (fileInput.files[0]) {
        formData.append('media', fileInput.files[0]);
    }

    fetch('php/SubirPost.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Post publicado exitosamente');
            location.reload(); // Recargar para mostrar el nuevo post
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al publicar el post');
    })
    .finally(() => {
        document.getElementById("create-post-form").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    });
});


// --- NUEVA FUNCIONALIDAD DE LIKES ---

// Usamos delegación de eventos en el contenedor principal de los posts
document.querySelector(".post-container").addEventListener("click", function(event) {
    const likeBtn = event.target.closest(".like-btn");

    if (!likeBtn) {
        return; // Si no se hizo clic en un botón de like, no hacemos nada
    }

    const postId = likeBtn.dataset.postId;
    const formData = new FormData();
    formData.append('post_id', postId);

    // Enviar la solicitud al servidor
    fetch('php/like_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar la UI sin recargar la página
            const likeCountSpan = likeBtn.querySelector(".like-count");
            const icon = likeBtn.querySelector("i");

            // Actualizar el contador de likes
            likeCountSpan.textContent = data.newLikeCount;

            // Cambiar el estado del botón (clase 'liked' y el ícono)
            likeBtn.classList.toggle('liked', data.userHasLiked);
            icon.className = data.userHasLiked ? 'bi bi-heart-fill' : 'bi bi-heart';
            
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error en la solicitud de like:', error));
});