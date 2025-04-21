<?php

require_once __DIR__ . '/../config/config.php';

class User
{

    private $db;

    public function __construct()
    {

        require_once __DIR__ . '/Database.php';

        $database = new Database();

        $this->db = $database->getConnection();
    }

    public function authenticate($username, $password)
    {

        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam('username', $username);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;

    }

    public function registerUser($username, $email, $password){
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam("username", $username);
        $stmt->bindParam(":email", $email);

        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    
    
    public function updateUserById($userID, $data){
        $sql = "UPDATE users SET username = :username, email = :email, level_user = :level_user, img_url = :img_url WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':level_user', $data['level_user'], PDO::PARAM_INT);
        $stmt->bindParam(':img_url', $data['img_url']);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function deleteUserById($userID){
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }
    


}
