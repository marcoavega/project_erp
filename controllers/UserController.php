<?php
// Se requiere el modelo de usuario y la conexión a la base de datos para gestionar las operaciones de usuario.
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Database.php';

// Definición de la clase `UserController`, que se encarga de manejar las operaciones sobre usuarios.
class UserController {

    // Propiedad privada que almacena la instancia del modelo de usuario.
    private $userModel;

    // **Constructor**: Se ejecuta cuando se instancia la clase.
    public function __construct(){
        $this->userModel = new User(); // Se crea una instancia del modelo `User`.
    }

    // **Método para obtener todos los usuarios**
    public function getAllUsers(){
        $dbInstance = new Database(); // Se instancia la base de datos.
        $pdo = $dbInstance->getConnection(); // Se obtiene la conexión PDO.
        
        // Se ejecuta una consulta SQL para obtener todos los usuarios y sus datos principales.
        $stmt = $pdo->query("SELECT user_id, username, email, level_user, created_at, updated_at, img_url FROM users");

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Se devuelve el resultado como un array asociativo.
    }

    // **Método para actualizar un usuario**
    public function updateUser($data){
        $dbInstance = new Database(); // Se instancia la base de datos.
        $pdo = $dbInstance->getConnection(); // Se obtiene la conexión PDO.
        
        // Se prepara la consulta SQL para actualizar la información del usuario.
        $stmt = $pdo->prepare("UPDATE users 
                               SET username = :username, 
                                   email = :email, 
                                   level_user = :level_user 
                               WHERE user_id = :user_id");

        // Se vinculan los valores a los parámetros de la consulta.
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':level_user', $data['level_user'], PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);

        // Se ejecuta la consulta y se devuelve un array con el estado de la actualización.
        if ($stmt->execute()){
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "No se pudo actualizar"];
        }
    }

    // **Método para actualizar el perfil del usuario**
    public function updateProfile($userID, $data) {
        $dbInstance = new Database(); // Se instancia la base de datos.
        $pdo = $dbInstance->getConnection(); // Se obtiene la conexión PDO.

        // Se construye la cláusula SET dinámicamente dependiendo de qué datos se actualizarán.
        $fields = "username = :username, email = :email";

        if (!empty($data['password'])) {
            $fields .= ", password = :password";
        }
        if (!empty($data['img_url'])) {
            $fields .= ", img_url = :img_url";
        }

        // Se prepara la consulta SQL con los campos dinámicos definidos anteriormente.
        $stmt = $pdo->prepare("UPDATE users SET $fields WHERE user_id = :user_id");

        // Se vinculan los parámetros con sus respectivos valores.
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

        // Si se proporcionó una nueva contraseña, se cifra antes de almacenarla.
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }

        if (!empty($data['img_url'])) {
            $stmt->bindParam(':img_url', $data['img_url']);
        }

        // Se ejecuta la consulta y se maneja cualquier error en la actualización.
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ["success" => false, "message" => "No se pudo actualizar: " . $errorInfo[2]];
        }
    }

    // **Método para eliminar un usuario**
    public function deleteUser($userID) {
        $dbInstance = new Database(); // Se instancia la base de datos.
        $pdo = $dbInstance->getConnection(); // Se obtiene la conexión PDO.
        
        // Se prepara la consulta SQL para eliminar el usuario por su ID.
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

        // Se ejecuta la consulta y se captura cualquier error.
        if ($stmt->execute()){
            return ["success" => true];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ["success" => false, "message" => "No se pudo eliminar: " . $errorInfo[2]];
        }
    }

    // **Método para crear un nuevo usuario**
    public function createUser($data) {
        $db   = (new Database())->getConnection(); // Se obtiene la conexión a la base de datos.

        // Se validan los datos antes de proceder con la inserción.
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            return ['success' => false, 'message' => 'Datos incompletos'];
        }

        // Se prepara la consulta SQL para insertar el usuario en la base de datos.
        $stmt = $db->prepare('INSERT INTO users (username,email,password,level_user) VALUES (:u,:e,:p,:l)');

        // Se cifra la contraseña usando el algoritmo BCRYPT antes de almacenarla.
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);

        // Se vinculan los parámetros con los valores correspondientes.
        $stmt->bindParam(':u', $data['username']);
        $stmt->bindParam(':e', $data['email']);
        $stmt->bindParam(':p', $hash);
        $stmt->bindParam(':l', $data['level_user'], PDO::PARAM_INT);

        // Se ejecuta la inserción y se captura el ID del nuevo usuario.
        if ($stmt->execute()) {
            $id = $db->lastInsertId();

            // Se consulta la información del usuario recién insertado para devolverla.
            $new = $db->prepare('SELECT user_id,username,email,level_user,created_at,updated_at,img_url FROM users WHERE user_id=:id');
            $new->bindParam(':id', $id, PDO::PARAM_INT);
            $new->execute();
            $user = $new->fetch(PDO::FETCH_ASSOC);

            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Error al insertar'];
        }
    }

}
?>
