<?php
// Obtiene el segmento desde el parámetro url en GET
$uri = $_GET['url'] ?? 'dashboard';
$segment = explode('/', trim($uri, '/'))[0];
?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar shadow-sm bg-dark-subtle m-0 p-0">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>dashboard">Mi Aplicación</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#mainNavbar" aria-controls="mainNavbar"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse flex-column flex-lg-row" id="mainNavbar">
      <!-- Menú principal -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
        <li class="nav-item px-2">
          <a class="nav-link text-body d-flex flex-column align-items-center <?= $segment === 'dashboard' ? 'active fw-bold' : '' ?>"
             href="<?= BASE_URL ?>dashboard">
            <i class="bi bi-house-door-fill fs-6 mb-1"></i>
            <span class="fs-6">Inicio</span>
          </a>
        </li>
        <li class="nav-item px-2">
          <a class="nav-link text-body d-flex flex-column align-items-center <?= $segment === 'admin_users' ? 'active fw-bold' : '' ?>"
             href="<?= BASE_URL ?>admin_users">
            <i class="bi bi-people-fill fs-6 mb-1"></i>
            <span class="fs-6">Usuarios</span>
          </a>
        </li>
        <!-- Añade más ítems según tus rutas -->
      </ul>

      <!-- Bloque derecho -->
      <div class="d-flex align-items-center">

        <!-- Toggle tema -->
        <button class="btn btn-outline-secondary me-3" id="themeToggleBtn" title="Cambiar tema">
          <i class="bi bi-sun-fill fs-6" id="iconLight"></i>
          <i class="bi bi-moon-fill fs-6 d-none" id="iconDark"></i>
        </button>

        <!-- Opciones -->
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="optionsMenu"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-gear-fill"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="optionsMenu">
            <li>
              <a class="dropdown-item" href="<?= BASE_URL ?>profile">
                
        <?php if (!empty($_SESSION['user']['img_url'])): ?>
          <img src="<?= BASE_URL . ltrim($_SESSION['user']['img_url'], '/')?>"
               alt="Foto de usuario"
               class="rounded-circle me-3"
               style="width:32px;height:32px;object-fit:cover;">
        <?php endif; ?> Perfil
              </a>
            </li>
            <li>
              <button class="dropdown-item" id="logoutButton">
                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
              </button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>



<?php
include __DIR__ . '/../modals/modal-logout.php';
?>

<!-- ==============================================
         Contenedor principal para el contenido dinámico
         ============================================= -->
<div class="container-fluid mt-0 m-0 p-0">
  <?php
  // Aquí se cargará el contenido dinámico de cada página.
  // Las vistas específicas establecerán lo que se debe mostrar aquí.
  echo $content;
  ?>
</div>


</body>

</html>