<?php
if (session_status() === PHP_SESSION_NONE) {
   
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => ini_get('session.cookie_path'),
        'domain'   => '', // En desarrollo, puede dejarse vacío o ajustarse según tu servidor local
        'secure'   => false, // Cambiado a false para entornos sin HTTPS
        'httponly' => true,
        'samesite' => 'Lax'  // 'Lax' es menos estricto que 'Strict' y suele funcionar bien en desarrollo
    ]);
    
    session_start();
}

$expirationTime = 3600; // 1 hora

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $expirationTime) {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "auth/login/");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
