document.addEventListener('DOMContentLoaded', function() {
    const toggleSwitch = document.getElementById('themeToggleSwitch');
    const htmlElement = document.documentElement; // Apunta al <html>
    
    // Recuperar el tema guardado en localStorage, o usar 'light' por defecto.
    let currentTheme = localStorage.getItem('theme') || 'light';
    htmlElement.setAttribute('data-bs-theme', currentTheme);
    
    // Configurar el estado inicial del interruptor según el tema actual.
    toggleSwitch.checked = (currentTheme === 'dark');
    // Actualizar la etiqueta del interruptor
    updateToggleLabel(currentTheme);
    
    toggleSwitch.addEventListener('change', function() {
        // Alternar entre 'light' y 'dark'
        currentTheme = toggleSwitch.checked ? 'dark' : 'light';
        htmlElement.setAttribute('data-bs-theme', currentTheme);
        // Guardar la selección en localStorage
        localStorage.setItem('theme', currentTheme);
        // Actualizar el texto del label para reflejar la acción que se realizará en el siguiente clic.
        updateToggleLabel(currentTheme);
    });
    
    function updateToggleLabel(theme) {
        const label = document.querySelector('label[for="themeToggleSwitch"]');
        label.textContent = theme === 'light' ? 'Tema Oscuro' : 'Tema Claro';
    }
});