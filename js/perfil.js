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
    
    // --- INICIO DE LA MODIFICACIÓN: MANEJAR POSTS DINÁMICOS ---
    // Seleccionar elementos de la vista completa para llenarlos dinámicamente
    const fullPostDescription = Full.querySelector(".post-description");
    const ownerName = Full.querySelector(".owner-name");
    const ownerPicture = Full.querySelector(".owner-picture");
  
    // ABRE EL POST FULL
    document.querySelectorAll(".post").forEach((post) => {
        post.addEventListener("click", () => {
            // Obtener datos del post desde los atributos data-*
            const postImageSrc = post.querySelector(".post-image").src;
            const postContent = post.dataset.postContent;
            const postOwnerName = post.dataset.ownerName;
            const postOwnerPic = post.dataset.ownerPic;
  
            // Llenar el modal con la información del post
            FullImage.src = postImageSrc;
            fullPostDescription.textContent = postContent;
            ownerName.textContent = postOwnerName;
            ownerPicture.src = postOwnerPic;
  
            // Mostrar el modal
            Full.style.display = "flex";
        });
    });
    // --- FIN DE LA MODIFICACIÓN ---
  
    // CIERRA EL POST FULL
    if (closeFull) {
        closeFull.addEventListener("click", () => {
            Full.style.display = "none";
        });
    }
  
    // CIERRA EL POST FULL al hacer clic fuera del contenedor
    window.addEventListener("click", (event) => {
        if (event.target === Full) {
            Full.style.display = "none";
        }
    });
  
    // ABRE EL CONTENEDOR DE EDICIÓN Y CIERRA POST FULL
    document.querySelectorAll(".edit-post-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const postImage = document.getElementById("FullPostImage").src;
  
            editPostPreview.src = postImage;
            // Asignar descripción actual al textarea de edición
            editPostDescription.value = fullPostDescription.textContent;
  
            // CIERRA EL POST
            Full.style.display = "none";
  
            //MUESTRA EL CONTENEDOR
            editPostForm.style.display = "flex";
        });
    });
  
    // CIERRA EL CONTENEDOR DE EDICIÓN
    if (closeEdit) {
        closeEdit.addEventListener("click", () => {
            editPostForm.style.display = "none";
        });
    }
  
    // CIERRA EL CONTENEDOR DE EDICIÓN AL HACER CLIC FUERA
    window.addEventListener("click", (event) => {
        if (event.target === editPostForm) {
            editPostForm.style.display = "none";
        }
    });
  
    // DESCARTAR CAMBIOS
    if (discardChangesBtn) {
        discardChangesBtn.addEventListener("click", () => {
            editPostForm.style.display = "none";
        });
    }
  });