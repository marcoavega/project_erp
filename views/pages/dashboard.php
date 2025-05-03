<?php
// views/pages/dashboard.php
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

// Determinar segmento actual desde parámetro 'url'
$uri = $_GET['url'] ?? 'dashboard';
$segment = explode('/', trim($uri, '/'))[0];

ob_start();
$username = htmlspecialchars($_SESSION['user']['username']);

// Definición de items del menú
$menuItems = [
    'dashboard'   => ['icon' => 'house-fill',   'label' => 'Panel de Control'],
    'admin_users' => ['icon' => 'people-fill',  'label' => 'Usuarios'],
    'settings'    => ['icon' => 'gear-fill',    'label' => 'Configuración'],
];
?>

<div class="container-fluid m-0 p-0">
  <div class="row m-0 p-0">
    <!-- Sidebar fijo en md+ -->
    <nav class="col-md-2 d-none d-md-block sidebar min-vh-100 m-0 p-0">
      <ul class="nav flex-column pt-3">
        <?php foreach ($menuItems as $route => $item): ?>
          <li class="nav-item mb-2">
            <a class="nav-link text-body d-flex align-items-center <?php echo $segment === $route ? 'active fw-bold' : '' ?>" href="<?php echo BASE_URL . $route ?>">
              <i class="bi bi-<?php echo $item['icon'] ?> me-2"></i> <?php echo $item['label'] ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <!-- Contenido principal ocupa col-12 en sm y col-md-10 en md+ -->
    <main class="col-12 col-md-10 px-4 py-3">
      <!-- Botón menú móvil solo xs–sm -->
      <div class="d-md-none mb-3">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" id="mobileMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-list me-1"></i> Menú
          </button>
          <ul class="dropdown-menu w-100" aria-labelledby="mobileMenuBtn">
            <?php foreach ($menuItems as $route => $item): ?>
              <li>
                <a class="dropdown-item <?php echo $segment === $route ? 'active fw-bold' : '' ?>" href="<?php echo BASE_URL . $route ?>">
                  <i class="bi bi-<?php echo $item['icon'] ?> me-1"></i> <?php echo $item['label'] ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
        <h1 class="h2">Panel de Control</h1>
        <span class="text-muted">Bienvenido, <?php echo $username ?>.</span>
      </div>

      <!-- Tiles -->
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

      <!-- Accesos rápidos -->
      <div class="card shadow-sm mb-4">
        <div class="card-header">
          <h5 class="mb-0">Accesos Rápidos</h5>
        </div>
        <div class="card-body d-flex flex-wrap gap-2">
          <a href="<?php echo BASE_URL ?>admin_users" class="btn btn-outline-primary">
            <i class="bi bi-people-fill fs-4 me-1"></i> Usuarios
          </a>
          <a href="<?php echo BASE_URL ?>products" class="btn btn-outline-success">
            <i class="bi bi-box-seam fs-4 me-1"></i> Productos
          </a>
          <a href="<?php echo BASE_URL ?>orders" class="btn btn-outline-warning">
            <i class="bi bi-cart-check fs-4 me-1"></i> Órdenes
          </a>
          <a href="<?php echo BASE_URL ?>reports" class="btn btn-outline-danger">
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
