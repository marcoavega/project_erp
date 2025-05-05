// **Evento que ejecuta el script cuando el DOM ha sido completamente cargado**
// `DOMContentLoaded` asegura que el código se ejecute solo cuando la página está lista,
// evitando errores por la ausencia de elementos que aún no han sido cargados.
document.addEventListener('DOMContentLoaded', function() {

    // ------------------------------------------------------------------
    // Manejo del botón "Cerrar Sesión"
    // ------------------------------------------------------------------
    var logoutButton = document.getElementById('logoutButton');
    // `getElementById('logoutButton')` busca el botón en el DOM con el ID `logoutButton`.
    // Si el botón no existe, `logoutButton` será `null` y el código no seguirá ejecutándose.

    if (logoutButton) { 
        // Si el botón existe, se agrega un evento de "click" con `addEventListener()`.
        logoutButton.addEventListener('click', function(e) {
            e.preventDefault(); // Evita que el botón siga su comportamiento predeterminado.
            
            // ------------------------------------------------------------------
            // Se crea y muestra el modal de confirmación de cierre de sesión.
            // `bootstrap.Modal()` inicializa el modal de Bootstrap asociado con `logoutConfirmModal`.
            // `.show()` hace que el modal se muestre en pantalla para que el usuario confirme la acción.
            // ------------------------------------------------------------------
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutConfirmModal'));
            logoutModal.show();
        });
    }

    // ------------------------------------------------------------------
    // Manejo del botón de confirmación dentro del modal
    // ------------------------------------------------------------------
    var confirmLogout = document.getElementById('confirmLogout');
    // `getElementById('confirmLogout')` busca el botón dentro del modal de confirmación de cierre de sesión.

    if (confirmLogout) { 
        // Si el botón de confirmación existe, se agrega un evento de "click".
        confirmLogout.addEventListener('click', function() {
            
            // ------------------------------------------------------------------
            // Redirige al usuario a la página de logout cuando confirma la acción.
            // `window.location.href` cambia la URL del navegador a la especificada.
            // `BASE_URL + "auth/logout"` lleva al usuario al endpoint de cierre de sesión.
            // ------------------------------------------------------------------
            window.location.href = BASE_URL + "auth/logout";
        });
    }
});
