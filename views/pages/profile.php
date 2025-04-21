<?php
if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

// Extraer datos del usuario desde la sesión activa
$user = $_SESSION['user'];
$username   = htmlspecialchars($user['username']);
$email      = htmlspecialchars($user['email']);
$level_user = htmlspecialchars($user['level_user']);
$created_at = isset($user['created_at']) ? htmlspecialchars($user['created_at']) : 'No disponible';
$updated_at = isset($user['updated_at']) ? htmlspecialchars($user['updated_at']) : 'No disponible';

// Si se tiene una ruta relativa para la imagen, se concatena con BASE_URL
$img = !empty($user['img_url'])
         ? BASE_URL . $user['img_url']
         : BASE_URL . "assets/images/users/user.png";

ob_start();
?>
<div class="container mt-5">
  <h2 class="mb-4 text-center text-md-start">Mi Perfil</h2>
  
  <!-- Card principal del perfil -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <div class="row">
        <!-- Columna de imagen de perfil y acción -->
        <div class="col-md-4 text-center">
          <img src="<?php echo $img; ?>" alt="Imagen de Perfil" class="img-fluid rounded-circle mb-3" style="max-width: 200px; object-fit: cover;">
          <button class="btn btn-primary" id="edit-profile-btn">Editar Perfil</button>
        </div>
        <!-- Columna de información -->
        <div class="col-md-8">
          <h5 class="mb-3">Datos del Perfil</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Usuario:</strong> <?php echo $username; ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo $email; ?></li>
            <li class="list-group-item"><strong>Nivel:</strong> <?php echo $level_user; ?></li>
            <li class="list-group-item"><strong>Creado:</strong> <?php echo $created_at; ?></li>
            <li class="list-group-item"><strong>Actualizado:</strong> <?php echo $updated_at; ?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Sección opcional: Tabulator para mostrar información adicional (ej. actividad reciente) -->
  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="mb-0">Mi Actividad Reciente</h5>
    </div>
    <div class="card-body">
      <div id="activity-table"></div>
    </div>
  </div>
</div>

<!-- Modal para editar perfil (incluye tu modal si procede) -->
<?php
include __DIR__ . '/../partials/modals/modal_edit_profile.php';

$content = ob_get_clean();
include __DIR__ . '/../partials/layouts/navbar.php';
?>

<!-- Definir BASE_URL global para JavaScript -->
<script>
  var BASE_URL = "<?php echo BASE_URL; ?>";
</script>

<!-- Lógica para el perfil (tu archivo profile.js) -->
<script src="<?php echo BASE_URL; ?>assets/js/ajax/profile.js"></script>

<!-- Opcional: inicialización de Tabulator para actividad reciente -->
<script>
  // Supón que se obtiene la actividad a través de AJAX o se utiliza datos estáticos.
  // En este ejemplo, se usa un array vacío para la demo.
  var activityData = []; // Aquí podrías cargar datos desde BASE_URL + 'api/...' o una variable global
  
  var table = new Tabulator("#activity-table", {
    layout: "fitColumns",
    placeholder: "No hay actividad reciente",
    data: activityData,
    columns: [
      { title: "Fecha", field: "date", sorter: "date", hozAlign: "center" },
      { title: "Acción", field: "action", hozAlign: "center" },
      { title: "Detalle", field: "detail" }
    ]
  });
</script>
