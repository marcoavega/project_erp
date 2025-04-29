<?php
// views/pages/dashboard.php
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

ob_start();
$username = htmlspecialchars($_SESSION['user']['username']);
?>

<div class="container-fluid m-0 p-0">
  <div class="row m-0 p-0">
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
      <!-- Botón menú móvil con íconos -->
      <div class="d-md-none mb-3">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="mobileMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-list me-1"></i> Menú
          </button>
          <ul class="dropdown-menu" aria-labelledby="mobileMenuBtn">
            <li>
              <a class="dropdown-item" href="<?php echo BASE_URL . 'dashboard'; ?>">
                <i class="bi bi-house-fill me-1"></i> Dashboard
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo BASE_URL . 'admin_users'; ?>">
                <i class="bi bi-people-fill me-1"></i> Usuarios
              </a>
            </li>
            <!-- Resto de enlaces con íconos -->
          </ul>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <span class="text-muted">Bienvenido, <?php echo $username; ?>.</span>
      </div>

      <!-- Tiles con iconos -->
      <div class="row">
        <div class="col-md-3 mb-3">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <i class="bi bi-people-fill display-4 text-primary mb-2"></i>
              <h6>Usuarios</h6>
              <h2>--</h2>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <i class="bi bi-box-seam display-4 text-success mb-2"></i>
              <h6>Productos</h6>
              <h2>--</h2>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <i class="bi bi-cart-check display-4 text-warning mb-2"></i>
              <h6>Órdenes</h6>
              <h2>--</h2>
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-3">
          <div class="card shadow-sm text-center">
            <div class="card-body">
              <i class="bi bi-graph-up display-4 text-danger mb-2"></i>
              <h6>Reportes</h6>
              <h2>--</h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Accesos rápidos con iconos -->
      <div class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body d-flex flex-wrap gap-2">
          <a href="<?php echo BASE_URL . 'admin_users'; ?>" class="btn btn-outline-primary">
            <i class="bi bi-people-fill fs-4 me-1"></i> Usuarios
          </a>
          <a href="<?php echo BASE_URL . 'products'; ?>" class="btn btn-outline-success">
            <i class="bi bi-box-seam fs-4 me-1"></i> Productos
          </a>
          <a href="<?php echo BASE_URL . 'orders'; ?>" class="btn btn-outline-warning">
            <i class="bi bi-cart-check fs-4 me-1"></i> Órdenes
          </a>
          <a href="<?php echo BASE_URL . 'reports'; ?>" class="btn btn-outline-danger">
            <i class="bi bi-graph-up fs-4 me-1"></i> Reportes
          </a>
        </div>
      </div>

      <!-- Actividad reciente -->
      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Actividad Reciente</h5>
        </div>
        <div class="card-body">
          <div id="recent-activity-table"></div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Script para Tabulator -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var activityData = [];
    new Tabulator("#recent-activity-table", {
      layout: "fitColumns",
      placeholder: "No hay actividad reciente",
      data: activityData,
      columns: [
        { title: "Fecha", field: "date", sorter: "date", hozAlign: "center" },
        { title: "Usuario", field: "user", hozAlign: "left" },
        { title: "Acción", field: "action", hozAlign: "left" },
        { title: "Detalle", field: "detail", hozAlign: "left" }
      ],
    });
  });
</script>
