<?php

// Se requiere el modelo `User`, que maneja la autenticación y gestión de usuarios en la base de datos.
require_once __DIR__ . '/../models/User.php';

// **Definición de la clase `AuthController`**
// Esta clase maneja la autenticación de usuarios, incluyendo el registro, inicio de sesión y cierre de sesión.
class AuthController
{

    // **Método para registrar un nuevo usuario**
    public function register()
    {
        // **Gestión de sesión:**
        // Se verifica si la sesión está iniciada antes de usar `$_SESSION`.
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Si no hay sesión activa, la inicia.
        }

        // **Verificación del método de solicitud**:
        // Solo se permite el registro si la solicitud se realiza mediante `POST`.
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // **Obtención y saneamiento de datos**:
            // Se recogen los datos del formulario y se eliminan espacios innecesarios con `trim()`.
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // **Validaciones de datos**:
            // Se verifica que los campos requeridos no estén vacíos.

            if (empty($username)) {
                $_SESSION['error'] = "El nombre de usuario es requerido.";
                error_log("Error de sesión: " . $_SESSION['error']); // Guarda el error en el registro de logs del servidor.
                header("Location: " . BASE_URL . "auth/register/"); // Redirige al usuario al formulario de registro.
                exit(); // Detiene la ejecución para evitar procesamiento innecesario.
            }

            if (empty($email)) {
                $_SESSION['error'] = "El correo electrónico es requerido.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                // `filter_var()` valida el formato del email.
                $_SESSION['error'] = "El correo electrónico no es válido.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            }

            if (empty($password)) {
                $_SESSION['error'] = "La contraseña es requerida.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            } elseif (strlen($password) < 6) { 
                // `strlen()` verifica que la contraseña tenga al menos 6 caracteres.
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            }

            if (empty($confirm_password)) {
                $_SESSION['error'] = "La confirmación de la contraseña es requerida.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            } elseif ($password !== $confirm_password) {
                // Se verifica si las contraseñas coinciden.
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            }

            // **Instancia del modelo `User`**:
            $userModel = new User();
            $registered = $userModel->registerUser($username, $email, $password);

            if ($registered) {
                $_SESSION['success'] = "Usuario registrado exitosamente. Por favor, inicia sesión.";
                header("Location: " . BASE_URL . "auth/register");
                exit();
            } else {
                $_SESSION['error'] = "Error: No se pudo registrar el usuario, el nombre de usuario o el correo ya están registrados.";
                header("Location: " . BASE_URL . "auth/register");
                exit();
            }
        } else {
            // **Carga del formulario de registro** si el método no es POST.
            include __DIR__ . '/../views/pages/register.php';
        }
    }

    // **Método para iniciar sesión**
    public function login()
    {
        // Se inicia la sesión si no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Se verifica que la solicitud se haga con `POST`.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            // **Validaciones antes del inicio de sesión**
            if (empty($username)) {
                $_SESSION['error'] = "El nombre de usuario es obligatorio";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }

            if (empty($password)) {
                $_SESSION['error'] = "La contraseña es obligatoria";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }

            // **Autenticación del usuario**
            $userModel = new User();
            $user = $userModel->authenticate($username, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'level_user' => $user['level_user'],
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at'],
                    'img_url'    => $user['img_url']
                ];

                $_SESSION['flash'] = "Bienvenido, " . htmlspecialchars($user['username']);
                header("Location: " . BASE_URL . "dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Error en login, Usuario o Contraseña Incorrectos";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }
        } else {
            include __DIR__ . '/../views/pages/login.php';
        }
    }

    // **Método para cerrar sesión**
    public function logout()
    {
        // Se inicia sesión si no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array(); // Se vacía la sesión.

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }

        session_destroy(); // Se destruye la sesión.
        header("Location: " . BASE_URL . "auth/login/");
        exit();
    }
}
