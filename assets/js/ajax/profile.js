document.addEventListener("DOMContentLoaded", function () {
    // Botón para abrir el modal de edición
    const editProfileBtn = document.getElementById("edit-profile-btn");
    const saveProfileChangesBtn = document.getElementById("saveProfileChanges");

    editProfileBtn.addEventListener("click", function () {
        const modal = new bootstrap.Modal(document.getElementById("editProfileModal"));
        modal.show();
    });

    // Botón para guardar cambios
    saveProfileChangesBtn.addEventListener("click", function () {
        const form = document.getElementById("editProfileForm");
        const formData = new FormData(form);

        // (Opcional) Asegurarte de que los valores están en FormData.
        formData.append("username", document.getElementById("edit-username").value);
        formData.append("email", document.getElementById("edit-email").value);
        formData.append("password", document.getElementById("edit-password").value);

        // Enviar datos usando fetch sin establecer el Content-Type manualmente.
        fetch(BASE_URL + "api/profile.php?action=update", {
            method: "POST",
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error HTTP: " + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                alert("Error al actualizar perfil: " + data.message);
            } else {
                alert("Perfil actualizado correctamente");
                location.reload(); // Recargar para mostrar los datos actualizados
            }
        })
        .catch(error => {
            console.error("Error en la solicitud AJAX:", error);
        });
    });
});

