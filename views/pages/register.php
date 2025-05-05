<?php
// Verifica si hay un mensaje de éxito en la sesión
$successMessage = ""; // Se inicializa la variable vacía para evitar errores si no hay mensaje.

if (isset($_SESSION['success'])) {
    /* 
    - `isset($_SESSION['success'])` comprueba si la variable de sesión `success` está definida.
    - `$_SESSION` es una superglobal de PHP que permite almacenar datos de usuario que persisten entre páginas.
    - Si existe `$_SESSION['success']`, significa que el usuario completó una acción con éxito y hay un mensaje para mostrar.
    */
    
    $successMessage = $_SESSION['success']; // Se asigna el mensaje de éxito a la variable para ser mostrado en pantalla.
    
    unset($_SESSION['success']); // Se elimina el mensaje de la sesión para que no aparezca nuevamente tras actualizar la página.
}

// Verifica si hay un mensaje de error en la sesión
$errorMessage = ""; // Se inicializa en vacío para evitar problemas si no hay error registrado.

if (isset($_SESSION['error'])) {
    /* 
    - `isset($_SESSION['error'])` revisa si la variable de sesión `error` está definida.
    - Si existe `$_SESSION['error']`, significa que ocurrió un error y se debe informar al usuario.
    */
    
    $errorMessage = $_SESSION['error']; // Se asigna el mensaje de error a la variable para ser mostrado.
    
    unset($_SESSION['error']); // Se elimina la variable de sesión después de mostrarla, asegurando que no se repita al recargar.
}

// Se incluyen los archivos de estructura y configuración de la interfaz.
include __DIR__ . '/../partials/head.php'; // Carga el encabezado de la página (metadatos, enlaces a estilos y scripts).
include __DIR__ . '/../partials/button-theme.php'; // Agrega el botón para alternar entre tema oscuro y claro.
?>

<!-- Contenedor principal que garantiza que la página ocupe toda la altura de la pantalla -->
<div class="d-flex flex-column" style="min-height: 100vh;">
    
    <!-- Sección del contenido principal: el formulario de registro está centrado -->
    <div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
        <!-- 'container-fluid' permite que el formulario se extienda por toda la pantalla.
             'flex-grow-1' hace que ocupe el espacio disponible en la estructura flexible.
             'align-items-center' y 'justify-content-center' centran vertical y horizontalmente el formulario. -->

        <div class="card shadow-lg" style="width: 100%; max-width: 500px;">
            <!-- 'card' define un contenedor con borde y estructura ordenada.
                 'shadow-lg' añade una sombra pronunciada para un mejor efecto visual.
                 'width: 100%' permite flexibilidad en el diseño.
                 'max-width: 500px' evita que el formulario sea demasiado ancho en pantallas grandes. -->

            <div class="card-body">
                <h2 class="card-title text-center mb-4">Regístrate</h2>
                <!-- Título centralizado con margen inferior para espaciar los elementos. -->

                <form action="<?php echo BASE_URL; ?>auth/register" method="POST">
                    <!-- Formulario que envía los datos de registro al controlador de autenticación.
                         'method="POST"' se usa para enviar información sin que aparezca en la URL. -->

                    <!-- Campo: Nombre de Usuario -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <!-- Etiqueta que identifica el campo de nombre de usuario. -->

                        <div class="input-group">
                            <!-- 'input-group' agrupa el ícono y el campo de entrada para mejorar el diseño. -->
                            <span class="input-group-text" id="username-addon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Elige un nombre de usuario">
                            <!-- 'name="username"' define el identificador del campo para que el backend lo procese. -->
                        </div>
                    </div>
                    
                    <!-- Campo: Correo Electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text" id="email-addon">@</span>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="ejemplo@correo.com" aria-describedby="email-addon">
                            <!-- 'type="email"' asegura que la entrada tenga formato de correo válido. -->
                        </div>
                    </div>
                    
                    <!-- Campo: Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" id="password-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Ingresa tu contraseña">
                            <!-- 'type="password"' oculta el texto ingresado para mayor seguridad. -->
                        </div>
                    </div>
                    
                    <!-- Campo: Confirmar Contraseña -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" id="confirm_password-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                   placeholder="Confirma tu contraseña">
                        </div>
                    </div>
                    
                    <!-- Botón de registro -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info">Registrarse</button>
                        <!-- 'btn-info' le da color azul para indicar la acción de registro. -->
                    </div>
                </form>

                <hr>
                <p class="text-center mb-0">¿Ya tienes cuenta?</p>
                <!-- Mensaje que invita al usuario a iniciar sesión si ya tiene un perfil creado. -->

                <div class="d-grid">
                    <a href="<?php echo BASE_URL; ?>login" class="btn btn-outline-info">Inicia sesión</a>
                    <!-- Botón con un borde azul ('btn-outline-info') que redirige al inicio de sesión. -->
                </div>
            </div>
        </div>
    </div>

<?php
// Se incluye el modal de registro, donde se pueden mostrar validaciones o mensajes de confirmación.
include __DIR__ . '/../partials/modals/modals-register.php';
?>
