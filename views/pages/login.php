<?php
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/button-theme.php';
?>

<div class="d-flex flex-column" style="min-height: 100vh;">
    <!-- Área principal: ocupa el espacio disponible -->
    <div class="container-fluid flex-grow-1 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-body text-center">
                <!-- Imagen de la empresa redonda -->
                <img src="<?php echo BASE_URL; ?>assets/images/logo/logo_empresa.png" 
                     alt="Logo de la Empresa" 
                     class="img-fluid rounded-circle mb-3" 
                     style="max-height: 100px; object-fit: contain;">
                
                <!-- Título del formulario -->
                <h2 class="card-title text-center mb-4">Iniciar Sesión.</h2>

                <!-- Formulario de login -->
                <form action="<?php echo BASE_URL; ?>auth/login" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text" id="username-addon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   placeholder="Tu nombre de usuario"
                                   aria-describe="username-addon"
                                   autocomplete="username">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text" id="password-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   placeholder="Tu contraseña">
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-info">Ingresar</button>
                    </div>
                    <hr>
                    <p class="text-center mb-0">¿No tienes cuenta?</p>
                    <div class="d-grid">
                        <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-outline-info">Regístrate aquí</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
include __DIR__ . '/../partials/modals/modals-login.php';
?>
