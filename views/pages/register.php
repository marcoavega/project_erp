<?php
// Verificar si hay un mensaje de éxito
$successMessage = "";
if (isset($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']); // Limpiar para que el mensaje no se repita
}

// Verificar si hay un mensaje de error
$errorMessage = "";
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']); // Limpiar para que el mensaje no se repita
}

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/button-theme.php';
?>

<div class="d-flex flex-column" style="min-height: 100vh;">
    
    <!-- Área del contenido principal: el formulario de registro se centra -->
    <div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Regístrate</h2>

                <form action="<?php echo BASE_URL; ?>auth/register" method="POST">
                    <!-- Campo: Nombre de Usuario -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text" id="username-addon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Elige un nombre de usuario">
                        </div>
                    </div>
                    
                    <!-- Campo: Correo Electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text" id="email-addon">@</span>
                            <input type="text" class="form-control" id="email" name="email"
                                   placeholder="ejemplo@correo.com" aria-describedby="email-addon">
                        </div>
                    </div>
                    
                    <!-- Campo: Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" id="password-addon">
                                <i class="bi bi-indent"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Ingresa tu contraseña">
                        </div>
                    </div>
                    
                    <!-- Campo: Confirmar Contraseña -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" id="confirm_password-addon">
                                <i class="bi bi-indent"></i>
                            </span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                   placeholder="Confirma tu contraseña">
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info">Registrarse</button>
                    </div>
                </form>

                <hr>
                <p class="text-center mb-0">¿Ya tienes cuenta?</p>
                <div class="d-grid">
                    <a href="<?php echo BASE_URL; ?>login" class="btn btn-outline-info">Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>

<?php
include __DIR__ . '/../partials/modals/modals-register.php';
?>