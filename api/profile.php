<?php
header('Content-Type: application/json');
session_start();

// Verificar si la sesión contiene datos válidos
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    echo json_encode(["success" => false, "message" => "Acceso no autorizado"]);
    exit();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/UserController.php';

$action = $_GET['action'] ?? '';

if ($action === 'update') {
    // Recibir datos vía POST
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email)) {
        echo json_encode(["success" => false, "message" => "Datos inválidos"]);
        exit();
    }


    $data = [];
    $data['username'] = $username;
    $data['email'] = $email;
    if (!empty($password)) {
        $data['password'] = $password;
    }

    // Procesar la imagen de perfil, si se envió
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === 0) {
        // Tipos permitidos: JPEG, PNG, GIF
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['user_image']['type'], $allowedTypes)) {
            echo json_encode(["success" => false, "message" => "Tipo de imagen no permitido."]);
            exit();
        }
        // Tamaño máximo permitido (2MB)
        $maxSize = 2097152; // 2MB en bytes
        if ($_FILES['user_image']['size'] > $maxSize) {
            echo json_encode(["success" => false, "message" => "El tamaño de la imagen debe ser menor a 2MB."]);
            exit();
        }
        // Obtener la extensión de la imagen en minúscula
        $ext = strtolower(pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION));
        // Ruta del directorio destino (asegúrate de que exista o créala)
        $destinationDir = __DIR__ . "/../assets/images/users/";
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }
        // Definir la ruta completa usando el nombre de usuario y la extensión
        $destination = $destinationDir . $username . "." . $ext;
        if (!move_uploaded_file($_FILES['user_image']['tmp_name'], $destination)) {
            echo json_encode(["success" => false, "message" => "Error al subir la imagen."]);
            exit();
        }
        // Guardamos la URL relativa en el campo "img_url"
        $data['img_url'] = "assets/images/users/" . $username . "." . $ext;
        // Actualizamos la sesión para que en la vista se muestre la imagen subida
        $_SESSION['user']['img_url'] = $data['img_url'];
    }



    $userController = new UserController();
    $userID = $_SESSION['user']['user_id'];

    $updateResult = $userController->updateProfile($userID, $data);

    if ($updateResult['success']) {
        // Actualizar la sesión después de los cambios
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        if (isset($data['img_url'])) {
            $_SESSION['user']['img_url'] = $data['img_url'];
        }
        echo json_encode([
            "success" => true,
            "message" => "Perfil actualizado correctamente",
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => $updateResult['message'],
        ]);
    }
    exit();
}

// Si no se reconoce la acción
echo json_encode(["success" => false, "message" => "Acción no válida"]);
exit();
