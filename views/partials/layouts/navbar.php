<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar shadow-sm">
  <div class="container-fluid px-3">
    <a class="navbar-brand fw-bold" href="<?php echo BASE_URL . 'dashboard'; ?>">Mi Aplicación</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#mainNavbar" aria-controls="mainNavbar"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Div contenedor con flex-column en móvil y flex-row en lg -->
    <div class="collapse navbar-collapse flex-column flex-lg-row" id="mainNavbar">
      <!-- Menú principal -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . 'dashboard'; ?>">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo BASE_URL . 'admin_users'; ?>">Usuarios</a>
        </li>
      </ul>

      <!-- Bloque derecho -->
      <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
        <span class="navbar-text mb-2 mb-lg-0 me-lg-2">
          Bienvenido, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
        </span>

        <?php if (!empty($_SESSION['user']['img_url'])): ?>
          <img
            src="<?= BASE_URL . ltrim($_SESSION['user']['img_url'], '/') ?>"
            alt="Foto de usuario"
            class="rounded-circle mb-2 mb-lg-0 me-lg-3"
            style="width: 40px; height: 40px; object-fit: cover;">
        <?php endif; ?>

        <!-- Switch de tema -->
        <div class="form-check form-switch mb-2 mb-lg-0 me-lg-3">
          <input class="form-check-input" type="checkbox" id="themeToggleSwitch">
          <label class="form-check-label" for="themeToggleSwitch">Tema Oscuro</label>
        </div>

        <!-- Menú desplegable "Opciones" -->
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="optionsMenu"
            data-bs-toggle="dropdown" aria-expanded="false">
            Opciones
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="optionsMenu">
            <li>
              <a class="dropdown-item" href="<?php echo BASE_URL . 'profile'; ?>">
                <i class="bi bi-person-circle"></i> Perfil
              </a>
            </li>
            <li>
              <button class="dropdown-item" id="logoutButton">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
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
<div class="container mt-4">
  <?php
  // Aquí se cargará el contenido dinámico de cada página.
  // Las vistas específicas establecerán lo que se debe mostrar aquí.
  echo $content;
  ?>
</div>

</body>

</html>