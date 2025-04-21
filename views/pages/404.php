<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Por favor inicia sesión para acceder al sistema.";
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

// Iniciar el buffer de salida para capturar el contenido de la vista
ob_start();

// Obtener datos del usuario y escaparlos
$username = htmlspecialchars($_SESSION['user']['username']);
?>

<div class="container mt-5 text-center">
  <h1 class="display-1 text-danger">404</h1>
  <h2 class="mb-3">Página no encontrada</h2>
  <p class="lead mb-4">
    Lo sentimos, la página que buscas no existe o ha sido movida.
  </p>
  <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-primary">
    <i class="bi bi-house-door-fill"></i> Volver al Dashboard
  </a>
</div>


<?php
// Capturar el contenido generado y asignarlo a la variable $content
$content = ob_get_clean();

// Ahora, incluye el layout base que mostrará el contenido ($content)
// Por ejemplo, si usas un layout que se llama layout.php y que espera la variable $content:
include __DIR__ . '/../partials/layouts/navbar.php'; 

?>
