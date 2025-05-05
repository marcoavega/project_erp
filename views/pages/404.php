<?php
// **Verificación del estado de la sesión**
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // `session_status()` verifica si la sesión está activa.
    // `PHP_SESSION_NONE` indica que no hay una sesión activa, por lo que `session_start()` la inicia.
}

// **Verificación de autenticación del usuario**
if (!isset($_SESSION['user'])) {
    // Si la variable de sesión `user` no está definida, significa que el usuario no ha iniciado sesión.
    
    $_SESSION['error'] = "Por favor inicia sesión para acceder al sistema.";
    // Se establece un mensaje de error en la sesión para notificar al usuario después de redirigirlo.
    
    header("Location: " . BASE_URL . "auth/login/");
    // Se redirige al usuario a la página de inicio de sesión.
    
    exit();
    // `exit()` detiene la ejecución del script inmediatamente después de la redirección.
}

// **Inicio del almacenamiento en búfer de salida**
ob_start();
// Se inicia la captura de salida para almacenar contenido antes de enviarlo al navegador.

// **Sanitización de datos del usuario**
$username = htmlspecialchars($_SESSION['user']['username']);
// `htmlspecialchars()` se utiliza para evitar ataques XSS,
// asegurando que caracteres especiales como `< > &` sean interpretados correctamente.
?>

<!-- **Página de error 404** -->
<div class="container mt-5 text-center">
  <!-- `container` estructura el contenido con los estilos de Bootstrap -->
  <!-- `mt-5` añade margen en la parte superior -->
  <!-- `text-center` centra el texto -->

  <h1 class="display-1 text-danger">404</h1>
  <!-- `display-1` muestra el texto en gran tamaño -->
  <!-- `text-danger` aplica el color rojo, indicando un error -->

  <h2 class="mb-3">Página no encontrada</h2>
  <!-- `mb-3` agrega margen inferior para separación visual -->

  <p class="lead mb-4">
    Lo sentimos, la página que buscas no existe o ha sido movida.
  </p>
  <!-- `lead` aumenta ligeramente el tamaño del texto para mejor legibilidad -->
  <!-- `mb-4` añade espacio debajo del párrafo -->

  <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-primary">
    <i class="bi bi-house-door-fill"></i> Volver al Dashboard
  </a>
  <!-- `btn btn-primary` crea un botón azul con estilo Bootstrap -->
  <!-- `bi bi-house-door-fill` es un ícono de Bootstrap que representa una casa -->
</div>

<?php
// **Capturar el contenido generado**
$content = ob_get_clean();
// `ob_get_clean()` obtiene el contenido almacenado en el búfer y lo limpia,
// permitiendo que se asigne a `$content` sin imprimirlo inmediatamente.

// **Incluir el layout base**
include __DIR__ . '/../partials/layouts/navbar.php'; 
// Se incluye el archivo del navbar para mantener la estructura de la aplicación.
?>
