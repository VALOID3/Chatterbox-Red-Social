document.addEventListener('DOMContentLoaded', () => {
    // Para el switch en navbar.php
    const darkModeToggleCheckbox = window.top.document.querySelector('.switch input[type="checkbox"]');
    const body = document.body; // El body de la página actual
    const topBody = window.top.document.body; // El body de la página principal (si navbar.php está en un iframe)

    // Función para aplicar el tema al body actual y al topBody (para consistencia en iframes)
    function applyTheme(isDarkMode) {
        if (isDarkMode) {
            body.classList.add('dark-mode');
            if (topBody && topBody !== body) { // Si hay un topBody diferente
                topBody.classList.add('dark-mode');
            }
        } else {
            body.classList.remove('dark-mode');
            if (topBody && topBody !== body) {
                topBody.classList.remove('dark-mode');
            }
        }
    }

    // Cargar la preferencia del usuario desde localStorage al cargar la página
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        applyTheme(true);
        if (darkModeToggleCheckbox) {
            darkModeToggleCheckbox.checked = true;
        }
    } else {
        applyTheme(false);
        if (darkModeToggleCheckbox) {
            darkModeToggleCheckbox.checked = false;
        }
    }

    // Escuchar el cambio en el checkbox del switch (en el navbar que está en el iframe)
    if (darkModeToggleCheckbox) {
        darkModeToggleCheckbox.addEventListener('change', () => {
            if (darkModeToggleCheckbox.checked) {
                applyTheme(true);
                localStorage.setItem('theme', 'dark');
            } else {
                applyTheme(false);
                localStorage.setItem('theme', 'light');
            }
        });
    }

    // Listener para eventos de almacenamiento (para sincronizar entre pestañas)
    window.addEventListener('storage', (e) => {
        if (e.key === 'theme') {
            applyTheme(e.newValue === 'dark');
            if (darkModeToggleCheckbox) {
                darkModeToggleCheckbox.checked = (e.newValue === 'dark');
            }
        }
    });

    // Función para actualizar el tema del iframe si cambia el padre
    if (window.self !== window.top) { // Si es un iframe
        const observer = new MutationObserver(() => {
            if (window.top.document.body.classList.contains('dark-mode') && !body.classList.contains('dark-mode')) {
                applyTheme(true);
            } else if (!window.top.document.body.classList.contains('dark-mode') && body.classList.contains('dark-mode')) {
                applyTheme(false);
            }
        });
        observer.observe(window.top.document.body, { attributes: true, attributeFilter: ['class'] });
    }
});