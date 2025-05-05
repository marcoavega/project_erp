// **Evento que ejecuta el script cuando el DOM ha sido completamente cargado**
// `DOMContentLoaded` asegura que el código se ejecute solo cuando la página está lista,
// evitando errores por la ausencia de elementos que aún no han sido cargados.
document.addEventListener("DOMContentLoaded", function () {

    // ------------------------------------------------------------------
    // Botón para abrir el modal de edición de perfil
    // Se selecciona el botón que activará el modal cuando el usuario quiera editar su perfil.
    // ------------------------------------------------------------------
    const editProfileBtn = document.getElementById("edit-profile-btn");
    const saveProfileChangesBtn = document.getElementById("saveProfileChanges"); // Botón para guardar cambios.

    // ------------------------------------------------------------------
    // Evento: Cuando el usuario hace clic en "Editar Perfil"
    // Se instancia el modal de Bootstrap y se muestra en pantalla.
    // ------------------------------------------------------------------
    editProfileBtn.addEventListener("click", function () {
        const modal = new bootstrap.Modal(document.getElementById("editProfileModal")); 
        modal.show(); // Se muestra el modal de edición de perfil.
    });

    // ------------------------------------------------------------------
    // Evento: Cuando el usuario hace clic en "Guardar Cambios"
    // ------------------------------------------------------------------
    saveProfileChangesBtn.addEventListener("click", function () {

        // **Se obtiene el formulario de edición de perfil**
        const form = document.getElementById("editProfileForm");

        // **Se crea un objeto FormData**
        // `FormData` permite enviar los datos del formulario como objeto, sin necesidad de modificar el `Content-Type` manualmente.
        const formData = new FormData(form);

        // **Opcional: Asegurar valores antes de enviarlos**
        // Se agregan los valores manualmente a `FormData`, aunque ya los contiene por defecto desde el formulario.
        formData.append("username", document.getElementById("edit-username").value);
        formData.append("email", document.getElementById("edit-email").value);
        formData.append("password", document.getElementById("edit-password").value);

        // ------------------------------------------------------------------
        // Se envían los datos al servidor utilizando `fetch()`
        // `fetch()` realiza una solicitud HTTP sin necesidad de librerías externas.
        // Se usa `POST` porque se están enviando datos para actualizar información.
        // ------------------------------------------------------------------
        fetch(BASE_URL + "api/profile.php?action=update", {
            method: "POST",
            body: formData, // Se envían los datos sin necesidad de modificar el Content-Type.
        })
        .then(response => {
            // **Verificación del estado de la respuesta HTTP**
            // Si la respuesta no es satisfactoria (`!response.ok`), se lanza un error con el código HTTP.
            if (!response.ok) {
                throw new Error("Error HTTP: " + response.status);
            }
            return response.json(); // Se convierte la respuesta a JSON.
        })
        .then(data => {
            // **Manejo de la respuesta del servidor**
            if (!data.success) {
                // Si `data.success` es `false`, se muestra un mensaje de error al usuario.
                alert("Error al actualizar perfil: " + data.message);
            } else {
                // Si la actualización es exitosa, se muestra un mensaje de éxito.
                alert("Perfil actualizado correctamente");

                // **Recarga la página para reflejar los cambios**
                // Se usa `location.reload()` para que el usuario vea los datos actualizados sin necesidad de cerrar sesión.
                location.reload();
            }
        })
        .catch(error => {
            // **Manejo de errores en la solicitud AJAX**
            // Se captura cualquier error que ocurra en la comunicación con el servidor.
            console.error("Error en la solicitud AJAX:", error);
        });
    });

});
