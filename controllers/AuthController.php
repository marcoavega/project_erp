<?php
require_once __DIR__ . '/../models/User.php';

class AuthController{

    public function register(){

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = ($_POST['password']);
            $confirm_password = ($_POST['confirm_password']);

            if (empty($username)) {
                $_SESSION['error'] = "El nombre de usuario es requerido.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            }

            if (empty($email)){
                $_SESSION['error'] = "El correo electronico es requerido.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $_SESSION['error'] = "El correo electronico no es valido.";
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
                $_SESSION['error'] = "Las contraseñas no coinciden.";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/register/");
                exit();
            }

            $userModel = new User();
            $registered = $userModel->registerUser($username, $email, $password);

            if ($registered) {
                // Establece un mensaje de éxito en la sesión
                $_SESSION['success'] = "Usuario registrado exitosamente. Por favor, inicia sesión.";
                // Redirigir de nuevo al formulario de registro para que la vista cargue el modal
                header("Location: " . BASE_URL . "auth/register");
                exit();
            } else {
                $_SESSION['error'] = "Error: No se pudo registrar el usuario, el nombre de usuario o el correo ya están registrados.";
                header("Location: " . BASE_URL . "auth/register");
                exit();
            }
            
            

        } else {

            include __DIR__ . '/../views/pages/register.php';

        }

    }


    public function login()
    {
        // Asegurarse de que la sesión esté iniciada para poder usar $_SESSION.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar el método de la solicitud.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si se envía el formulario de login (método POST).

            // Recoger y limpiar los datos del formulario.
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            // Se obtiene el nombre de usuario y la contraseña ingresados.


            // Validamos que el nombre de usuario no esté vacío.
            if (empty($username)) {
                $_SESSION['error'] = "El nombre de usuario es obligatorio";
                // Si el nombre de usuario está vacío, se almacena un mensaje de error en la sesión.
                // Esto permite mostrar el error en la vista sin perder los datos ingresados.
                error_log("Error de sesión: " . $_SESSION['error']);                // Se registra el error en el log de errores del servidor.
                // "error_log()" es útil para depurar y rastrear problemas en el código.
                header("Location: " . BASE_URL . "auth/login/");
                // Se redirige al usuario a la página de registro para corregir el error.
                exit();
            }
            // Validamos que se haya ingresado una contraseña.
            if (empty($password)) {
                $_SESSION['error'] = "La contraseña es obligatoria";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }
            // Validamos que la contraseña tenga al menos 6 caracteres.
            if (strlen($password) < 6) {
                $_SESSION['error'] = "La contraseña debe tener al menos 6 caracteres";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }


            // Instanciar el modelo User para autenticar al usuario.
            $userModel = new User();
            // Se crea un nuevo objeto User para acceder a sus métodos.
            $user = $userModel->authenticate($username, $password);
            // Se llama al método authenticate que verifica la existencia del usuario
            // y la validez de la contraseña utilizando password_verify().

            if ($user) {
                // Si la autenticación es exitosa:
                // Se guardan solo los campos esenciales en la sesión (id, username y email).
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'level_user' => $user['level_user'],
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at'],
                    'img_url'    => $user['img_url']
                ];
                // Este enfoque evita exponer datos sensibles o innecesarios en la sesión.

                // Se crea un mensaje flash para dar la bienvenida.
                $_SESSION['flash'] = "Bienvendio, " . htmlspecialchars($user['username']);
                // "htmlspecialchars()" se usa para evitar que caracteres especiales se interpreten incorrectamente.

                // Redirigir al dashboard, que es la vista principal del sistema.
                header("Location: " . BASE_URL . "dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Error en login, Usuario o Contraseña Incorrectos";
                error_log("Error de sesión: " . $_SESSION['error']);
                header("Location: " . BASE_URL . "auth/login/");
                exit();
            }

        } else {
            // Si la solicitud no es POST, es decir, es GET:
            include __DIR__ . '/../views/pages/login.php';
            // Se carga la vista del formulario de login.
        }
    }


    public function logout() {
        // Asegurarse de que la sesión esté activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vaciar todas las variables de sesión
        $_SESSION = array();
        
        // Si la sesión utiliza cookies, eliminamos la cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params(); // Obtenemos los parámetros de la cookie.
            // La función setcookie con un tiempo en el pasado elimina la cookie.
            setcookie(
                session_name(), 
                '', 
                time() - 42000, 
                $params["path"], 
                $params["domain"], 
                $params["secure"], 
                $params["httponly"]
            );
        }
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir al usuario al formulario de login
        header("Location: " . BASE_URL . "auth/login/");
        exit();
    }
    

}