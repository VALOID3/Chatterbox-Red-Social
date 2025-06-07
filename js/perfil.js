document.addEventListener("DOMContentLoaded", function () {

  const Full = document.getElementById("postFull");
  // --- NUEVO --- Contenedor para la imagen o video en el modal
  const fullImageContainer = Full.querySelector(".Full-image");
  const closeFull = document.querySelector(".close-Full");
  const editPostForm = document.getElementById("edit-post-form");
  const editPostPreview = document.getElementById("edit-post-preview");
  const editPostDescription = document.getElementById("edit-post-desc");
  const saveChangesBtn = document.querySelector(".edit-post-save");
  const deletePostBtn = document.querySelector(".edit-post-delete");
  const discardChangesBtn = document.querySelector(".edit-post-discard");

  const fullPostDescription = Full.querySelector(".post-description");
  const ownerName = Full.querySelector(".owner-name");
  const ownerPicture = Full.querySelector(".owner-picture");
  const downloadLink = document.getElementById("download-link");

  let currentPostId = null;

  document.querySelectorAll(".post").forEach((post) => {
    post.addEventListener("click", () => {
      // --- MODIFICADO --- Se obtienen los nuevos datos del post
      const mediaType = post.dataset.mediaType;
      const mediaBase64 = post.dataset.mediaBase64;
      const postContent = post.dataset.postContent;
      const postOwnerName = post.dataset.ownerName;
      const postOwnerPic = post.dataset.ownerPic;
      currentPostId = post.dataset.postId;
      
      // --- MODIFICADO --- Lógica para crear y mostrar imagen o video en el modal
      fullImageContainer.innerHTML = ''; // Limpiar el contenedor
      let mediaElement;

      if (mediaType === 'video') {
          const videoSrc = `data:video/mp4;base64,${mediaBase64}`;
          mediaElement = document.createElement('video');
          mediaElement.src = videoSrc;
          mediaElement.controls = true; // Añadir controles al video
          mediaElement.autoplay = true; // Opcional: que inicie automáticamente
          downloadLink.href = videoSrc;
          downloadLink.download = "Chatterbox-Post.mp4";
      } else { // Si no es video, es imagen
          const imgSrc = `data:image/jpeg;base64,${mediaBase64}`;
          mediaElement = document.createElement('img');
          mediaElement.src = imgSrc;
          downloadLink.href = imgSrc;
          downloadLink.download = "Chatterbox-Post.jpg";
      }

      // Estilos para que el elemento ocupe el contenedor
      mediaElement.style.width = '100%';
      mediaElement.style.height = '100%';
      mediaElement.style.objectFit = 'cover';
      fullImageContainer.appendChild(mediaElement);
      
      // Llenar el resto de la información del modal
      fullPostDescription.textContent = postContent;
      ownerName.textContent = postOwnerName;
      ownerPicture.src = postOwnerPic;

      Full.style.display = "flex";
    });
  });

  if (closeFull) {
    closeFull.addEventListener("click", () => {
      Full.style.display = "none";
    });
  }

  window.addEventListener("click", (event) => {
    if (event.target === Full) {
      Full.style.display = "none";
    }
  });

  document.querySelectorAll(".edit-post-btn").forEach((button) => {
    button.addEventListener("click", () => {
      // --- MODIFICADO --- Obtener la imagen o el video del modal para la previsualización
      const currentMediaElement = fullImageContainer.querySelector('img, video');
      if (currentMediaElement) {
           // La previsualización en la edición siempre usará una etiqueta <img>
           // Para un video, mostrará el primer fotograma.
          editPostPreview.src = currentMediaElement.src;
      }
      editPostDescription.value = fullPostDescription.textContent;
      Full.style.display = "none";
      editPostForm.style.display = "flex";
    });
  });

  if (discardChangesBtn) {
    discardChangesBtn.addEventListener("click", () => {
      editPostForm.style.display = "none";
    });
  }

  if (saveChangesBtn) {
      saveChangesBtn.addEventListener("click", () => {
          const nuevaDescripcion = editPostDescription.value;
          fetch('php/actualizar_publicacion.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({
                  post_id: currentPostId,
                  descripcion: nuevaDescripcion
              })
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  const postElement = document.querySelector(`.post[data-post-id='${currentPostId}']`);
                  if (postElement) {
                      postElement.dataset.postContent = nuevaDescripcion;
                  }
                  fullPostDescription.textContent = nuevaDescripcion;
                  editPostForm.style.display = "none";
                  alert("¡Publicación actualizada con éxito!");
              } else {
                  alert("Error: " + data.message);
              }
          })
          .catch(error => {
              console.error('Error en la solicitud:', error);
              alert("Ocurrió un error al conectar con el servidor.");
          });
      });
  }
  
  if (deletePostBtn) {
    deletePostBtn.addEventListener("click", () => {
      if (confirm("¿Estás seguro de que quieres eliminar esta publicación? Esta acción no se puede deshacer.")) {
        fetch('php/eliminar_publicacion.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ post_id: currentPostId })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.querySelector(`.post[data-post-id='${currentPostId}']`)?.remove();
            editPostForm.style.display = "none";
            Full.style.display = "none";
            alert(data.message);
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch(error => {
          console.error('Error en la solicitud:', error);
          alert("Ocurrió un error al conectar con el servidor.");
        });
      }
    });
  }
  
});