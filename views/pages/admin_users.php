<?php
// views/pages/admin_users.php
// Verificar que la sesión esté iniciada; si no, redirigir al login.
if (!isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "auth/login/");
  exit();
}
ob_start();
?>

<div class="container-fluid p-0">
  <div class="row g-0">
    <!-- Sidebar -->
    <nav class="col-md-2 d-md-block sidebar min-vh-100 m-0 p-0">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link text-body" href="<?php echo BASE_URL . 'dashboard'; ?>">
            <i class="bi bi-house-fill me-2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-body" href="<?php echo BASE_URL . 'admin_users'; ?>">
            <i class="bi bi-people-fill me-2"></i> Usuarios
          </a>
        </li>
      </ul>
    </nav>


    <!-- Contenido principal -->
    <main class="col-md-10 ms-sm-auto px-4 py-3">
      <?php if ($_SESSION['user']['level_user'] != 1): ?>
        <h2>Acceso Denegado</h2>
        <div class="alert alert-danger">No tienes permiso para ver esta página.</div>
      <?php else: ?>
        <div class="mb-4">
          <h2 class="mb-4 text-center text-md-start">Administración de Usuarios</h2>
        </div>

        <div class="row mb-3">
          <div class="col-12 d-flex flex-wrap justify-content-start justify-content-md-end">
            <button id="exportCSVBtn" class="btn btn-outline-primary me-2 mb-2">Exportar a CSV</button>
            <button id="exportExcelBtn" class="btn btn-outline-success me-2 mb-2">Exportar a Excel</button>
            <button id="exportPDFBtn" class="btn btn-outline-danger me-2 mb-2">Exportar a PDF</button>
            <button id="exportJSONBtn" class="btn btn-outline-secondary mb-2">Exportar a JSON</button>
          </div>
        </div>

        <!-- Buscador -->
        <div class="row mb-3">
          <div class="col-12">
            <input type="text" id="table-search" class="form-control" placeholder="Buscar usuarios por nombre o email">
          </div>
        </div>

        <!-- Contenedor para la tabla -->
        <div class="row">
          <div class="col-12">
            <div id="users-table"></div>
          </div>
        </div>

        <!-- Modals -->
        <?php
        include __DIR__ . '/../partials/modals/modal_edit_user.php';
        include __DIR__ . '/../partials/modals/modal_delete_user.php';
        ?>
      <?php endif; ?>
    </main>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script admin-users -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/admin-users.js"></script>