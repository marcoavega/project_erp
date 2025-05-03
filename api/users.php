<?php
// Asegúrate de que la respuesta sea JSON puro
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/UserController.php';

$action = $_GET['action'] ?? '';

$userController = new UserController();

switch ($action) {
    case 'get':
        $users = $userController->getAllUsers();
        echo json_encode($users);
        break;

    case 'update':
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $userController->updateUser($data['userData'] ?? []);
        if ($result['success']) {
            echo json_encode([
                "success" => true,
                "message" => "Usuario actualizado correctamente",
                "updatedData" => $data['userData']
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No se pudo actualizar"
            ]);
        }
        break;
        
    case 'delete':
        // Para eliminar, se espera recibir el user_id desde el JSON
        $data = json_decode(file_get_contents("php://input"), true);
        $userID = $data['user_id'] ?? 0;
        $result = $userController->deleteUser($userID);
        echo json_encode($result);
        break;

    default:
        echo json_encode(["error" => "Acción no definida"]);
        break;


        case 'create':
            $data = json_decode(file_get_contents('php://input'), true)['userData'] ?? [];
            $result = $userController->createUser($data);
            if ($result['success']) {
                echo json_encode(['success' => true, 'newUser' => $result['user']]);
            } else {
                echo json_encode(['success' => false, 'message' => $result['message']]);
            }
            break;
        


}
exit();
