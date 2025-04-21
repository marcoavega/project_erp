<?php
// Verificar que la sesión esté iniciada; si no, redirigir al login.
if (!isset($_SESSION['user'])) {
  header("Location: " . BASE_URL . "auth/login/");
  exit();
}
ob_start();
?>

<div class="container mt-5">
  <?php if ($_SESSION['user']['level_user'] != 1): ?>
    <!-- Usuario autenticado pero sin permisos de administrador -->
    <h2>Acceso Denegado</h2>
    <div class="alert alert-danger">
      No tienes permiso para ver esta página.
    </div>
  <?php else: ?>
    
  <!-- Vista para administrador -->
<div class="container">
  <h2 class="mb-4 text-center text-md-start">Administración de Usuarios</h2>
</div>


    <div class="container mt-4">
      <div class="row">
        <div class="col-12 d-flex flex-wrap justify-content-center justify-content-md-end mb-3">
          <button id="exportCSVBtn" class="btn btn-outline-primary me-2 mb-2">
            Exportar a CSV
          </button>
          <button id="exportExcelBtn" class="btn btn-outline-success me-2 mb-2">
            Exportar a Excel
          </button>
          <button id="exportPDFBtn" class="btn btn-outline-danger me-2 mb-2">
            Exportar a PDF
          </button>
          <button id="exportJSONBtn" class="btn btn-outline-secondary mb-2">
            Exportar a JSON
          </button>
        </div>
      </div>
    </div>



    <!-- Buscador -->
    <div class="mb-3">
      <input type="text" id="table-search" class="form-control" placeholder="Buscar usuarios por nombre o email">
    </div>

    <!-- Contenedor para la tabla -->
    <div id="users-table"></div>

    <!-- Modal de Actualización -->
    <!-- Modal de Confirmación para Eliminar -->
    <?php
    include __DIR__ . '/../partials/modals/modal_edit_user.php';
    include __DIR__ . '/../partials/modals/modal_delete_user.php';
    ?>

  <?php endif; ?>
</div>

<?php
// Cerrar el buffer y luego incluir el navbar
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Incluir el archivo JavaScript de admin-users -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/admin-users.js"></script>