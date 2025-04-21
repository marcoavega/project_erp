<?php
require_once 'config/config.php';

include __DIR__ . '/views/inc/session_start.php';
include __DIR__ . '/views/partials/head.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'login';

$parts = explode('/', $url);

if ($parts[0] == 'auth'){
    
    require_once 'controllers/AuthController.php';
    
    $auth = new AuthController();

    $action = isset($parts[1]) ? trim($parts[1], "/ ") : '';

    if ($action !== "" && method_exists($auth, $action)) {
        $auth->$action();
    } else {
        echo "<h1>Error: Acción no encontrada en AuthController.</h1>";
    }
} else {
    
    require_once 'controllers/RouteController.php';

    $controller = new RouteController();

    $controller->loadPage($url);
}

include __DIR__ . '/views/partials/footer.php';