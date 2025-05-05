<!-- Modal de Éxito de Registro -->
<?php if (!empty($successMessage)): ?> 
<!-- Esta condición verifica si la variable $successMessage contiene un mensaje. Si está vacía, el modal no se mostrará. 
     Esto ayuda a que el modal solo aparezca cuando haya un mensaje de éxito tras completar el registro correctamente. -->

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <!-- Define la estructura del modal con Bootstrap. 
         'fade' permite animación de desvanecimiento al mostrarse.
         'tabindex="-1"' evita que el modal reciba foco por teclado cuando está oculto.
         'aria-labelledby' asocia el modal con el título para mejorar accesibilidad.
         'aria-hidden="true"' indica que el modal no es accesible cuando está cerrado. -->

    <div class="modal-dialog modal-dialog-centered">
        <!-- 'modal-dialog' es el contenedor principal del modal.
             'modal-dialog-centered' centra el modal verticalmente en la pantalla. -->

        <div class="modal-content">
            <!-- 'modal-content' contiene la estructura y contenido del modal. -->

            <div class="modal-header bg-success text-white">
                <!-- 'modal-header' es el encabezado del modal.
                     'bg-success' usa el color verde de Bootstrap para indicar éxito.
                     'text-white' mantiene el texto en color blanco para mejor contraste. -->
                <h5 class="modal-title" id="successModalLabel">¡Registro Exitoso!</h5>
                <!-- Define el título del modal y lo asocia con el atributo 'aria-labelledby'. -->

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                <!-- Botón de cierre del modal. 'data-bs-dismiss="modal"' indica que al hacer clic, se cerrará el modal.
                     'aria-label="Cerrar"' proporciona accesibilidad al describir su función para lectores de pantalla. -->
            </div>

            <div class="modal-body">
                <?php echo $successMessage; ?>
                <!-- Muestra el mensaje de éxito que proviene del backend.
                     Puede contener detalles adicionales como "Registro completado correctamente". -->
            </div>

            <div class="modal-footer">
                <!-- Sección de pie del modal, donde suelen colocarse botones de acción. -->
                <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-primary">Iniciar Sesión</a>
                <!-- Botón para redirigir al usuario a la página de inicio de sesión.
                     Usa 'BASE_URL' para mantener rutas dinámicas dentro del sistema. -->
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 
<!-- Cierra la condición PHP. Si $successMessage estaba vacío, el código del modal nunca se ejecutó. -->

<!-- Modal de Error -->
<?php if (!empty($errorMessage)): ?>
<!-- Si $errorMessage contiene un mensaje de error, entonces el modal se mostrará, permitiendo alertar al usuario. -->

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <!-- La estructura del modal de error es similar al de éxito, pero con colores diferentes. -->

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <!-- 'bg-danger' cambia el encabezado a rojo, indicando un error. -->
                <h5 class="modal-title" id="errorModalLabel">Error de Validación</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                <!-- Botón para cerrar el modal, con accesibilidad integrada. -->
            </div>

            <div class="modal-body">
                <?php echo $errorMessage; ?>
                <!-- Muestra el mensaje de error proveniente del backend. 
                     Puede incluir errores como "Correo electrónico inválido" o "Contraseña demasiado corta". -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!-- Botón para cerrar el modal sin redirigir a otra página.
                     'btn-secondary' usa un color gris neutro. -->
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 
<!-- Se cierra la verificación PHP. Si $errorMessage está vacío, el modal no se muestra. -->
