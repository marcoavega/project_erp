// **Evento que ejecuta el script cuando el DOM ha sido completamente cargado**
// `DOMContentLoaded` asegura que el código se ejecute solo cuando la página está lista,
// evitando errores por la ausencia de elementos que aún no han sido cargados.
document.addEventListener('DOMContentLoaded', function() {

    // ------------------------------------------------------------------
    // Mostrar modal de éxito si existe en el DOM
    // ------------------------------------------------------------------
    var successModalElement = document.getElementById('successModal');
    // `getElementById('successModal')` busca el elemento con el ID `successModal`.
    // Si el modal no está presente en la página, `successModalElement` será `null`.

    if (successModalElement) {
        // Si el modal de éxito existe, se crea una instancia del modal de Bootstrap.
        var successModal = new bootstrap.Modal(successModalElement);

        // Se muestra el modal en pantalla para que el usuario vea el mensaje de éxito.
        successModal.show();
    }

    // ------------------------------------------------------------------
    // Mostrar modal de error si existe en el DOM
    // ------------------------------------------------------------------
    var errorModalElement = document.getElementById('errorModal');
    // `getElementById('errorModal')` busca el elemento con el ID `errorModal`.
    // Si no existe, `errorModalElement` será `null`, lo que evitará errores.

    if (errorModalElement) {
        // Si el modal de error está presente en la página, se crea su instancia de Bootstrap.
        var errorModal = new bootstrap.Modal(errorModalElement);

        // Se muestra el modal en pantalla, indicando al usuario que ha ocurrido un error.
        errorModal.show();
    }
});
