document.addEventListener('DOMContentLoaded', function() {
    // Configuración para imagen de perfil
    const profilePicUpload = document.getElementById('profile-pic-upload');
    profilePicUpload.addEventListener('change', function(e) {
        handleImageUpload(this, 'profile-pic', 'current-profile-pic');
    });

    // Configuración para imagen de fondo
    const backgroundPicUpload = document.getElementById('background-pic-upload');
    backgroundPicUpload.addEventListener('change', function(e) {
        handleImageUpload(this, 'background-pic', 'current-background-pic');
    });

    // Función común para manejar subidas de imágenes
    function handleImageUpload(input, fieldName, previewId) {
        if (input.files && input.files[0]) {
            // Validaciones
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const fileType = input.files[0].type;
            
            if (!validTypes.includes(fileType)) {
                alert('Solo se permiten imágenes JPEG, PNG o GIF');
                resetFileInput(input);
                return;
            }
            
            if (input.files[0].size > 2 * 1024 * 1024) {
                alert('La imagen no debe exceder 2MB');
                resetFileInput(input);
                return;
            }
            
            // Previsualización
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewElement = document.getElementById(previewId);
                if (previewElement) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                }
            };
            reader.readAsDataURL(input.files[0]);
            
            // Crear formulario para enviar
            const formData = new FormData();
            formData.append(fieldName, input.files[0]);
            
            // Mostrar loader (opcional)
            const button = input.id === 'profile-pic-upload' 
                ? document.querySelector('.btn-change-photo')
                : document.querySelector('.btn-change-bg');
                
            button.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Subiendo...';
            
            // Enviar con AJAX
            fetch('EditarP.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.text();
            })
            .then(text => {
                console.log('Imagen subida correctamente:', text);
                // Restaurar texto del botón
                if (input.id === 'profile-pic-upload') {
                    button.innerHTML = 'Cambiar Foto de Perfil';
                } else {
                    button.innerHTML = 'Cambiar Imagen de Fondo';
                }
            })
            .catch(error => {
                console.error('Error al subir imagen:', error);
                alert('Error al subir la imagen. Por favor intenta nuevamente.');
                resetFileInput(input);
                
                // Restaurar texto del botón
                if (input.id === 'profile-pic-upload') {
                    button.innerHTML = 'Cambiar Foto de Perfil';
                } else {
                    button.innerHTML = 'Cambiar Imagen de Fondo';
                }
            });
        }
    }

    // Función para resetear el input file
    function resetFileInput(input) {
        input.value = '';
        
        // Restaurar imagen de preview si es necesario
        if (input.id === 'profile-pic-upload') {
            const currentImg = document.getElementById('current-profile-pic').dataset.original;
            if (currentImg) {
                document.getElementById('current-profile-pic').src = currentImg;
            }
        } else if (input.id === 'background-pic-upload') {
            const currentImg = document.getElementById('current-background-pic').dataset.original;
            if (currentImg) {
                document.getElementById('current-background-pic').src = currentImg;
            }
        }
    }

    // Guardar las imágenes originales como data attributes
    const originalProfilePic = document.getElementById('current-profile-pic').src;
    const originalBackgroundPic = document.getElementById('current-background-pic').src;
    
    document.getElementById('current-profile-pic').dataset.original = originalProfilePic;
    document.getElementById('current-background-pic').dataset.original = originalBackgroundPic;
});