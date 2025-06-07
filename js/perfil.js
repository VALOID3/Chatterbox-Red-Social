document.addEventListener("DOMContentLoaded", function () {

    const Full = document.getElementById("postFull");
    const FullImage = document.getElementById("FullPostImage");
    const closeFull = document.querySelector(".close-Full");
    const editPostForm = document.getElementById("edit-post-form");
    const editPostPreview = document.getElementById("edit-post-preview");
    const editPostDescription = document.getElementById("edit-post-desc");
    const closeEdit = document.querySelector(".close-edit");
    const saveChangesBtn = document.querySelector(".edit-post-save");
    const deletePostBtn = document.querySelector(".edit-post-delete");
    const discardChangesBtn = document.querySelector(".edit-post-discard");
  
    const fullPostDescription = Full.querySelector(".post-description");
    const ownerName = Full.querySelector(".owner-name");
    const ownerPicture = Full.querySelector(".owner-picture");
    
    // --- INICIO DE LA MODIFICACIÓN: OBTENER ENLACE DE DESCARGA ---
    const downloadLink = document.getElementById("download-link");
    // --- FIN DE LA MODIFICACIÓN ---
  
    let currentPostId = null;
  
    document.querySelectorAll(".post").forEach((post) => {
      post.addEventListener("click", () => {
        const postImageSrc = post.querySelector(".post-image").src;
        const postContent = post.dataset.postContent;
        const postOwnerName = post.dataset.ownerName;
        const postOwnerPic = post.dataset.ownerPic;
        currentPostId = post.dataset.postId;
        
        FullImage.src = postImageSrc;
        fullPostDescription.textContent = postContent;
        ownerName.textContent = postOwnerName;
        ownerPicture.src = postOwnerPic;
        
        // --- INICIO DE LA MODIFICACIÓN: ASIGNAR URL AL BOTÓN DE DESCARGA ---
        downloadLink.href = postImageSrc;
        // --- FIN DE LA MODIFICACIÓN ---
  
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
        const postImage = document.getElementById("FullPostImage").src;
        editPostPreview.src = postImage;
        editPostDescription.value = fullPostDescription.textContent;
        Full.style.display = "none";
        editPostForm.style.display = "flex";
      });
    });
  
    if (closeEdit) {
      closeEdit.addEventListener("click", () => {
        editPostForm.style.display = "none";
      });
    }
  
    window.addEventListener("click", (event) => {
      if (event.target === editPostForm) {
        editPostForm.style.display = "none";
      }
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
          headers: {
            'Content-Type': 'application/json'
          },
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
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              post_id: currentPostId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const postElement = document.querySelector(`.post[data-post-id='${currentPostId}']`);
              if (postElement) {
                postElement.remove();
              }
              editPostForm.style.display = "none";
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