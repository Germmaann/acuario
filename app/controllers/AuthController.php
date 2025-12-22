<?php
/**
 * AuthController
 * Maneja autenticación, registro y recuperación de contraseña
 */

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Vista de login
     */
    public function loginView() {
        if (Session::isLogged()) {
            Response::redirect(APP_URL . '/fish');
        }
        
        $pageTitle = 'Iniciar Sesión';
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/auth/login.php';
    }

    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Método no permitido');
        }

        // Validar token CSRF
        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token de seguridad inválido');
            Response::redirect(APP_URL . '/auth/login');
        }

        $email = Security::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validar email
        if (empty($email) || !Security::validateEmail($email)) {
            Response::setFlash('error', 'Email inválido');
            Response::redirect(APP_URL . '/auth/login');
        }

        // Validar contraseña
        if (empty($password) || strlen($password) < 6) {
            Response::setFlash('error', 'Contraseña inválida');
            Response::redirect(APP_URL . '/auth/login');
        }

        // Obtener usuario
        $user = $this->userModel->getByEmail($email);

        if (!$user) {
            Security::logSecurityEvent('LOGIN_FAILED', ['email' => $email, 'reason' => 'user_not_found']);
            Response::setFlash('error', 'Email o contraseña incorrectos');
            Response::redirect(APP_URL . '/auth/login');
        }

        // Verificar contraseña
        if (!Security::verifyPassword($password, $user['password_hash'])) {
            Security::logSecurityEvent('LOGIN_FAILED', ['email' => $email, 'reason' => 'wrong_password']);
            Response::setFlash('error', 'Email o contraseña incorrectos');
            Response::redirect(APP_URL . '/auth/login');
        }

        // Verificar que usuario esté activo
        if (!$user['is_active']) {
            Security::logSecurityEvent('LOGIN_FAILED', ['email' => $email, 'reason' => 'inactive_user']);
            Response::setFlash('error', 'Usuario desactivado');
            Response::redirect(APP_URL . '/auth/login');
        }

        // Actualizar último login
        $this->userModel->updateLastLogin($user['id']);

        // Guardar en sesión
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('user_role', $user['role_name']);
        Session::set('email', $user['email']);
        Session::set('full_name', $user['full_name']);

        Security::logSecurityEvent('LOGIN_SUCCESS', ['user_id' => $user['id'], 'username' => $user['username']]);
        
        Response::setFlash('success', 'Bienvenido ' . $user['full_name'] . '!');
        Response::redirect(APP_URL . '/fish');
    }

    /**
     * Vista de registro
     */
    public function registerView() {
        if (Session::isLogged()) {
            Response::redirect(APP_URL . '/fish');
        }

        $pageTitle = 'Registrarse';
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/auth/register.php';
    }

    /**
     * Procesar registro
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Método no permitido');
        }

        // Validar token CSRF
        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token de seguridad inválido');
            Response::redirect(APP_URL . '/auth/register');
        }

        $username = Security::sanitize($_POST['username'] ?? '');
        $email = Security::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $fullName = Security::sanitize($_POST['full_name'] ?? '');

        // Validaciones
        $errors = [];

        if (empty($username) || strlen($username) < 3) {
            $errors[] = 'El usuario debe tener al menos 3 caracteres';
        }

        if (preg_match('/[^a-z0-9_-]/i', $username)) {
            $errors[] = 'El usuario solo puede contener letras, números, guiones y guiones bajos';
        }

        if (empty($email) || !Security::validateEmail($email)) {
            $errors[] = 'Email inválido';
        }

        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'La contraseña debe tener al menos 6 caracteres';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Las contraseñas no coinciden';
        }

        if (empty($fullName) || strlen($fullName) < 3) {
            $errors[] = 'El nombre debe tener al menos 3 caracteres';
        }

        // Verificar duplicados
        if ($this->userModel->usernameExists($username)) {
            $errors[] = 'El usuario ya existe';
        }

        if ($this->userModel->emailExists($email)) {
            $errors[] = 'El email ya está registrado';
        }

        if (!empty($errors)) {
            Response::setFlash('error', implode('<br>', $errors));
            Response::redirect(APP_URL . '/auth/register');
        }

        // Crear usuario
        try {
            $userId = $this->userModel->create([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'full_name' => $fullName
            ]);

            if ($userId) {
                Security::logSecurityEvent('USER_REGISTERED', ['user_id' => $userId, 'username' => $username]);
                Response::setFlash('success', 'Registro exitoso! Ahora puedes iniciar sesión.');
                Response::redirect(APP_URL . '/auth/login');
            } else {
                Response::setFlash('error', 'Error al registrar usuario');
                Response::redirect(APP_URL . '/auth/register');
            }
        } catch (Exception $e) {
            Response::setFlash('error', 'Error del sistema: ' . $e->getMessage());
            Response::redirect(APP_URL . '/auth/register');
        }
    }

    /**
     * Vista de recuperar contraseña
     */
    public function forgotPasswordView() {
        if (Session::isLogged()) {
            Response::redirect(APP_URL . '/fish');
        }

        $pageTitle = 'Recuperar Contraseña';
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/auth/forgot-password.php';
    }

    /**
     * Enviar email de recuperación
     */
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Método no permitido');
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $email = Security::sanitize($_POST['email'] ?? '');

        if (empty($email) || !Security::validateEmail($email)) {
            Response::json(['success' => false, 'message' => 'Email inválido'], 400);
        }

        $user = $this->userModel->getByEmail($email);

        if (!$user) {
            // No revelar si email existe o no por seguridad
            Response::json(['success' => true, 'message' => 'Si el email existe, recibirás instrucciones para recuperar tu contraseña']);
            return;
        }

        // Generar token
        $token = Security::generatePasswordResetToken();
        $this->userModel->setPasswordResetToken($user['id'], $token, 3600); // 1 hora

        // Aquí irían los envíos de email
        // mail($email, 'Recuperar contraseña', 'Token: ' . $token);

        Security::logSecurityEvent('PASSWORD_RESET_REQUESTED', ['user_id' => $user['id']]);
        Response::json(['success' => true, 'message' => 'Instrucciones enviadas. Revisa tu email.']);
    }

    /**
     * Logout
     */
    public function logout() {
        Security::logSecurityEvent('LOGOUT', ['user_id' => Session::getUserId()]);
        Session::destroy();
        Response::setFlash('success', 'Sesión cerrada correctamente');
        Response::redirect(APP_URL . '/auth/login');
    }
}
