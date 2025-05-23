// MUESTRA CREAR POST
document.querySelector(".create-post-btn").addEventListener("click", function () {
    document.getElementById("create-post-form").style.display = "block";
    document.getElementById("overlay").style.display = "block";
});

// BTN CANCELAR
document.getElementById("cancel-post").addEventListener("click", function () {
    document.getElementById("create-post-form").style.display = "none";
    document.getElementById("overlay").style.display = "none";
});

// OCULTA CREAR POST
document.getElementById("overlay").addEventListener("click", function (event) {
    if (event.target === document.getElementById("overlay")) {
        document.getElementById("create-post-form").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }
});

// PREVISUALIZACION DE IMAGE
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

// Agrega esto al final del archivo dashboard.js

// PUBLICAR POST
document.getElementById("publish-post").addEventListener("click", function() {
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