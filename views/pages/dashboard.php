<?php
// views/pages/dashboard.php
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

ob_start();
$username = htmlspecialchars($_SESSION['user']['username']);
?>

<div class="container-fluid mt-5">
    <!-- Encabezado del Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3">Dashboard</h1>
            <p class="text-muted">Bienvenido, <?php echo $username; ?>. Esta es la página principal del sistema.</p>
        </div>
    </div>

    <!-- Tiles tipo Dolibarr/Odoo -->
    <div class="row">
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people-fill display-4 text-primary me-3"></i>
                        <div>
                            <h6 class="card-title mb-1">Usuarios</h6>
                            <h2 class="card-text">--</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-box-seam display-4 text-success me-3"></i>
                        <div>
                            <h6 class="card-title mb-1">Productos</h6>
                            <h2 class="card-text">--</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-cart-check display-4 text-warning me-3"></i>
                        <div>
                            <h6 class="card-title mb-1">Órdenes de Compra</h6>
                            <h2 class="card-text">--</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-graph-up display-4 text-danger me-3"></i>
                        <div>
                            <h6 class="card-title mb-1">Reportes</h6>
                            <h2 class="card-text">--</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos directos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <a href="<?php echo BASE_URL . 'admin_users'; ?>" class="btn btn-outline-primary m-2 text-center" style="width:120px;">
                            <i class="bi bi-people-fill fs-2"></i><br>
                            Usuarios
                        </a>
                        <a href="<?php echo BASE_URL . 'products'; ?>" class="btn btn-outline-success m-2 text-center" style="width:120px;">
                            <i class="bi bi-box-seam fs-2"></i><br>
                            Productos
                        </a>
                        <a href="<?php echo BASE_URL . 'orders'; ?>" class="btn btn-outline-warning m-2 text-center" style="width:120px;">
                            <i class="bi bi-cart-check fs-2"></i><br>
                            Órdenes
                        </a>
                        <a href="<?php echo BASE_URL . 'reports'; ?>" class="btn btn-outline-danger m-2 text-center" style="width:120px;">
                            <i class="bi bi-graph-up fs-2"></i><br>
                            Reportes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente con Tabulator -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Actividad Reciente</h5>
                </div>
                <div class="card-body">
                    <div id="recent-activity-table"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Scripts de Inicio de Dashboard -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos de ejemplo, sustituir por AJAX si hace falta
        var activityData = [];

        var table = new Tabulator("#recent-activity-table", {
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
