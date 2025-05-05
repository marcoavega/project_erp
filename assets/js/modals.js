// ================================================================ ==
// Archivo: main.js
// Propósito: Código JavaScript que se ejecuta cuando la página se carga.
// Se encarga de mostrar un modal de error utilizando Bootstrap si hay
// un mensaje de error presente en el HTML.
// ================================================================ ==

// **Evento que ejecuta el script cuando el DOM ha sido completamente cargado**
document.addEventListener('DOMContentLoaded', function() {

    // ------------------------------------------------------------------
    // Obtiene el elemento del modal de error por su ID "messageModal"
    // `getElementById()` selecciona el modal de error si existe en la página.
    // Si no existe, `errorModalElement` será `null`, lo cual se maneja más adelante.
    // ------------------------------------------------------------------
    const errorModalElement = document.getElementById('messageModal');
    
    // ------------------------------------------------------------------
    // Si el modal existe, buscar el contenedor del mensaje dentro del modal.
    // El mensaje de error está dentro de `.modal-body`.
    // Se obtiene y se elimina cualquier espacio en blanco alrededor con `trim()`.
    // ------------------------------------------------------------------
    if (errorModalElement) {
        const modalBody = errorModalElement.querySelector('.modal-body'); // Selecciona el contenido del modal.
        const errorMessage = modalBody.textContent.trim(); // Extrae el texto y elimina espacios innecesarios.

        // ------------------------------------------------------------------
        // Si hay un mensaje de error presente en el modal, se crea y muestra el modal.
        // `bootstrap.Modal()` inicializa el modal de Bootstrap.
        // `.show()` abre el modal para que el usuario vea el error.
        // ------------------------------------------------------------------
        if (errorMessage) {
            const errorModal = new bootstrap.Modal(errorModalElement); // Se instancia el modal.
            errorModal.show(); // Se muestra el modal en pantalla.
            
            // ------------------------------------------------------------------
            // Se agrega un evento para detectar cuando el modal se oculta.
            // `hidden.bs.modal` es un evento de Bootstrap que ocurre cuando el modal se ha cerrado.
            // Se usa `addEventListener()` para ejecutar la función cuando el evento sucede.
            // Cuando el modal se cierra, se limpia el contenido del mensaje dentro de `.modal-body`.
            // ------------------------------------------------------------------
            errorModalElement.addEventListener('hidden.bs.modal', function() {
                modalBody.textContent = ''; // Borra el mensaje de error para evitar que se vuelva a mostrar accidentalmente.
            });
        }
    }
});
