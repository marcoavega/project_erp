<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Database.php';

class UserController {

    private $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    public function getAllUsers(){
        $dbInstance = new Database();
        $pdo = $dbInstance->getConnection();
        $stmt = $pdo->query("SELECT user_id, username, email, level_user, created_at, updated_at, img_url FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUser($data){
        $dbInstance = new Database();
        $pdo = $dbInstance->getConnection();
        $stmt = $pdo->prepare("UPDATE users 
                               SET username = :username, 
                                   email = :email, 
                                   level_user = :level_user 
                               WHERE user_id = :user_id");
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':level_user', $data['level_user'], PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);

        if($stmt->execute()){
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "No se pudo actualizar"];
        }
    }

    public function updateProfile($userID, $data) {
        $dbInstance = new Database();
        $pdo = $dbInstance->getConnection();
    
        // Construir la cláusula SET dinámicamente
        $fields = "username = :username, email = :email";
        
        if (!empty($data['password'])) {
            $fields .= ", password = :password";
        }
        if (!empty($data['img_url'])) {
            $fields .= ", img_url = :img_url";
        }
    
        $stmt = $pdo->prepare("UPDATE users SET $fields WHERE user_id = :user_id");
    
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
    
        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hashedPassword);
        }
        if (!empty($data['img_url'])) {
            $stmt->bindParam(':img_url', $data['img_url']);
        }
    
        if ($stmt->execute()) {
            return ["success" => true];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ["success" => false, "message" => "No se pudo actualizar: " . $errorInfo[2]];
        }
    }
    
    
    public function deleteUser($userID) {
        $dbInstance = new Database();
        $pdo = $dbInstance->getConnection();
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        if($stmt->execute()){
            return ["success" => true];
        } else {
            $errorInfo = $stmt->errorInfo();
            return ["success" => false, "message" => "No se pudo eliminar: " . $errorInfo[2]];
        }
    }
    



    public function createUser($data) {
        $db   = (new Database())->getConnection();
        // Validaciones mínimas
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            return ['success'=>false, 'message'=>'Datos incompletos'];
        }
        // Insert
        $stmt = $db->prepare('INSERT INTO users (username,email,password,level_user) VALUES (:u,:e,:p,:l)');
        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':u',$data['username']);
        $stmt->bindParam(':e',$data['email']);
        $stmt->bindParam(':p',$hash);
        $stmt->bindParam(':l',$data['level_user'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            $id = $db->lastInsertId();
            // Leer el nuevo registro
            $new = $db->prepare('SELECT user_id,username,email,level_user,created_at,updated_at,img_url FROM users WHERE user_id=:id');
            $new->bindParam(':id',$id,PDO::PARAM_INT);
            $new->execute();
            $user = $new->fetch(PDO::FETCH_ASSOC);
            return ['success'=>true, 'user'=>$user];
        } else {
            return ['success'=>false,'message'=>'Error al insertar'];
        }
    }
    


    

}
?>
