function searchProfiles() {
  const input = document.getElementById('search-input').value;
  const container = document.querySelector('.cards-container');
  
  container.innerHTML = '<p class="loading">Buscando usuarios...</p>';

  fetch(`php/buscar_usuarios.php?q=${encodeURIComponent(input)}`)
      .then(response => {
          if (!response.ok) throw new Error('Error en el servidor');
          return response.json();
      })
      .then(usuarios => {
          container.innerHTML = '';

          if (!usuarios || usuarios.length === 0) {
              container.innerHTML = '<p class="no-results">No se encontraron usuarios.</p>';
              return;
          }

          usuarios.forEach(user => {
              // Usar imagen en base64 si existe, sino la imagen por defecto
              const imagenSrc = user.imagen_base64 || 'images/PorfileP.png';
              
              const card = document.createElement('a');
              card.href = `perfil.php?id=${user.id_Usuario}`;
              card.className = 'Card-individual';
              card.innerHTML = `
                  <div class="profile-picture-container">
                      <img src="${imagenSrc}" 
                           class="profile-picture" 
                           alt="${user.nom_usuario}"
                           onerror="this.src='images/PorfileP.png'">
                  </div>
                  <div class="profile-info">
                      <h2 class="profile-username">@${user.nom_usuario}</h2>
                  </div>
              `;
              container.appendChild(card);
          });
      })
      .catch(error => {
          console.error('Error:', error);
          container.innerHTML = `<p class="error">Error: ${error.message}</p>`;
      });
}

document.addEventListener("DOMContentLoaded", searchProfiles);