<?php

// Se requiere el archivo de configuración, donde pueden estar definidas variables globales como BASE_URL, credenciales y otras constantes importantes.
require_once __DIR__ . '/../config/config.php';

// Definición de la clase User, que maneja la autenticación y gestión de usuarios en la base de datos.
class User
{
    // Propiedad privada para almacenar la conexión a la base de datos.
    private $db;

    // **Constructor de la clase**
    public function __construct()
    {
        // Se requiere el archivo de conexión a la base de datos.
        require_once __DIR__ . '/Database.php';

        // Se crea una instancia de la clase Database.
        $database = new Database();

        // Se asigna la conexión PDO de la base de datos a la propiedad `$db`.
        $this->db = $database->getConnection();
    }

    // **Método para autenticar un usuario**
    public function authenticate($username, $password)
    {
        // Consulta SQL para buscar un usuario por nombre de usuario.
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        // Se prepara la consulta.
        $stmt = $this->db->prepare($sql);

        // Se vincula el parámetro `:username` con el valor recibido en el argumento.
        $stmt->bindParam('username', $username);

        // Se ejecuta la consulta.
        $stmt->execute();

        // Se obtiene el usuario como un array asociativo.
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se verifica la contraseña ingresada comparándola con la almacenada en la base de datos mediante `password_verify()`.
        if ($user && password_verify($password, $user['password'])){
            return $user; // Devuelve los datos del usuario si la autenticación es correcta.
        }

        return false; // Retorna `false` si el usuario no existe o la contraseña es incorrecta.
    }

    // **Método para registrar un usuario nuevo**
    public function registerUser($username, $email, $password)
    {
        // Se verifica si el usuario o correo ya existen en la base de datos.
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1";

        // Se prepara la consulta.
        $stmt = $this->db->prepare($sql);

        // Se vinculan los parámetros de consulta con los valores recibidos.
        $stmt->bindParam("username", $username);
        $stmt->bindParam(":email", $email);

        // Se ejecuta la consulta.
        $stmt->execute();

        // Si ya existe un usuario con el mismo nombre o email, la función retorna `false` y no continúa con el registro.
        if ($stmt->rowCount() > 0){
            return false;
        }

        // Se cifra la contraseña usando el algoritmo BCRYPT para mejorar la seguridad del sistema.
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Se define la consulta para insertar un nuevo usuario.
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

        // Se prepara la consulta.
        $stmt = $this->db->prepare($sql);

        // Se vinculan los parámetros con sus respectivos valores.
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        // Se ejecuta la consulta y se devuelve `true` si fue exitosa.
        return $stmt->execute();
    }

    // **Método para actualizar los datos de un usuario por su ID**
    public function updateUserById($userID, $data)
    {
        // Consulta SQL para actualizar el usuario según su ID.
        $sql = "UPDATE users SET username = :username, email = :email, level_user = :level_user, img_url = :img_url WHERE user_id = :user_id";

        // Se prepara la consulta.
        $stmt = $this->db->prepare($sql);

        // Se vinculan los parámetros con los valores del array `$data`.
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':level_user', $data['level_user'], PDO::PARAM_INT);
        $stmt->bindParam(':img_url', $data['img_url']);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

        // Se ejecuta la consulta y se devuelve `true` si fue exitosa.
        return $stmt->execute();
    }

    // **Método para eliminar un usuario por su ID**
    public function deleteUserById($userID)
    {
        // Se define la consulta SQL para eliminar el usuario de la base de datos.
        $sql = "DELETE FROM users WHERE user_id = :user_id";

        // Se prepara la consulta.
        $stmt = $this->db->prepare($sql);

        // Se vincula el parámetro `:user_id` con el ID recibido.
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);

        // Se ejecuta la consulta y se devuelve `true` si fue exitosa.
        return $stmt->execute();
    }

}
