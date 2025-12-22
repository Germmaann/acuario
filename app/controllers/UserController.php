<?php
/**
 * UserController
 * Maneja el perfil del usuario
 */

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Ver perfil público del usuario
     */
    public function publicProfile() {
        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $userId = (int)$_GET['id'];
        $user = $this->userModel->getById($userId);

        if (!$user) {
            Response::notFound();
        }

        // Obtener peces creados por el usuario
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            "SELECT * FROM fish_wiki WHERE author_id = ? AND status = ? ORDER BY created_at DESC LIMIT 12"
        );
        $stmt->execute([$userId, FISH_STATUS_APPROVED]);
        $userFish = $stmt->fetchAll();

        // Obtener acuarios del usuario
        $stmt = $db->prepare(
            "SELECT * FROM aquariums WHERE user_id = ? ORDER BY created_at DESC LIMIT 12"
        );
        $stmt->execute([$userId]);
        $userAquariums = $stmt->fetchAll();

        // Obtener estadísticas
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM fish_wiki WHERE author_id = ? AND status = ?");
        $stmt->execute([$userId, FISH_STATUS_APPROVED]);
        $fishCount = $stmt->fetch()['total'];

        $stmt = $db->prepare("SELECT COUNT(*) as total FROM aquariums WHERE user_id = ?");
        $stmt->execute([$userId]);
        $aquariumCount = $stmt->fetch()['total'];

        $stats = [
            'fish_contributed' => $fishCount,
            'aquariums' => $aquariumCount
        ];

        $pageTitle = 'Perfil de ' . htmlspecialchars($user['full_name']);
        require BASE_PATH . '/app/views/user/public-profile.php';
    }

    /**
     * Ver perfil del usuario
     */
    public function profile() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $userId = Session::getUserId();
        $user = $this->userModel->getById($userId);

        if (!$user) {
            Response::notFound();
        }

        // Obtener estadísticas
        $db = Database::getInstance()->getConnection();
        
        // Contar acuarios
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM aquariums WHERE user_id = ?");
        $stmt->execute([$userId]);
        $aquariumsCount = $stmt->fetch()['total'];

        // Contar peces contribuidos (creados por el usuario)
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM fish_wiki WHERE author_id = ?");
        $stmt->execute([$userId]);
        $fishContributed = $stmt->fetch()['total'];

        // Contar total de peces en acuarios
        $stmt = $db->prepare(
            "
            SELECT SUM(af.quantity) as total 
            FROM aquarium_fish af
            JOIN aquariums a ON af.aquarium_id = a.id
            WHERE a.user_id = ?
        "
        );
        $stmt->execute([$userId]);
        $totalFish = $stmt->fetch()['total'] ?? 0;

        $stats = [
            'aquariums' => $aquariumsCount,
            'fish_contributed' => $fishContributed,
            'total_fish' => $totalFish
        ];

        $pageTitle = 'Mi Perfil';
        require BASE_PATH . '/app/views/user/profile.php';
    }


    /**
     * Subir foto de perfil
     */
    public function uploadAvatar() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::redirect(APP_URL . '/user/profile');
        }

        $userId = Session::getUserId();

        // Validar archivo
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            Response::setFlash('error', 'Error al subir el archivo');
            Response::redirect(APP_URL . '/user/profile');
        }

        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = MAX_UPLOAD_SIZE; // 5MB

        // Validar tipo
        if (!in_array($file['type'], $allowedTypes)) {
            Response::setFlash('error', 'Solo se permiten imágenes JPG, PNG o GIF');
            Response::redirect(APP_URL . '/user/profile');
        }

        // Validar tamaño
        if ($file['size'] > $maxSize) {
            Response::setFlash('error', 'La imagen no debe superar 5MB');
            Response::redirect(APP_URL . '/user/profile');
        }

        // Generar nombre único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $extension;
        $uploadDir = UPLOADS_PATH . '/avatars/';
        $uploadPath = $uploadDir . $filename;

        // Crear directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Eliminar avatar anterior si existe
        $user = $this->userModel->getById($userId);
        if (!empty($user['avatar_path']) && file_exists(BASE_PATH . '/' . $user['avatar_path'])) {
            unlink(BASE_PATH . '/' . $user['avatar_path']);
        }

        // Mover archivo
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            Response::setFlash('error', 'Error al guardar la imagen');
            Response::redirect(APP_URL . '/user/profile');
        }

        // Actualizar base de datos
        $avatarPath = 'public/uploads/avatars/' . $filename;
        $this->userModel->updateAvatar($userId, $avatarPath);

        Response::setFlash('success', 'Foto de perfil actualizada correctamente');
        Response::redirect(APP_URL . '/user/profile');
    }

    /**
     * Eliminar foto de perfil
     */
    public function removeAvatar() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::redirect(APP_URL . '/user/profile');
        }

        $userId = Session::getUserId();
        $user = $this->userModel->getById($userId);

        // Eliminar archivo físico
        if (!empty($user['avatar_path']) && file_exists(BASE_PATH . '/' . $user['avatar_path'])) {
            unlink(BASE_PATH . '/' . $user['avatar_path']);
        }

        // Actualizar base de datos
        $this->userModel->updateAvatar($userId, null);

        Response::setFlash('success', 'Foto de perfil eliminada');
        Response::redirect(APP_URL . '/user/profile');
    }

    /**
     * Actualizar información del perfil
     */
    public function updateProfile() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::redirect(APP_URL . '/user/profile');
        }

        $userId = Session::getUserId();
        $fullName = Security::sanitize($_POST['full_name'] ?? '');
        $bio = Security::sanitize($_POST['bio'] ?? '');

        $this->userModel->updateProfile($userId, $fullName, $bio);

        Response::setFlash('success', 'Perfil actualizado correctamente');
        Response::redirect(APP_URL . '/user/profile');
    }

    /**
     * Vista para cambiar contraseña
     */
    public function changePasswordView() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $pageTitle = 'Cambiar Contraseña';
        $csrfToken = Security::generateCsrfToken();
        $contentView = BASE_PATH . '/app/views/user/change-password-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Procesar cambio de contraseña
     */
    public function changePassword() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Método no permitido');
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token de seguridad inválido');
            Response::redirect(APP_URL . '/user/change-password');
        }

        $userId = Session::getUserId();
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validar contraseñas
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            Response::setFlash('error', 'Todos los campos son requeridos');
            Response::redirect(APP_URL . '/user/change-password');
        }

        if (strlen($newPassword) < 6) {
            Response::setFlash('error', 'La nueva contraseña debe tener al menos 6 caracteres');
            Response::redirect(APP_URL . '/user/change-password');
        }

        if ($newPassword !== $confirmPassword) {
            Response::setFlash('error', 'Las contraseñas no coinciden');
            Response::redirect(APP_URL . '/user/change-password');
        }

        // Obtener usuario actual
        $user = $this->userModel->getById($userId);
        
        if (!$user || !Security::verifyPassword($currentPassword, $user['password_hash'])) {
            Response::setFlash('error', 'Contraseña actual incorrecta');
            Response::redirect(APP_URL . '/user/change-password');
        }

        // Actualizar contraseña
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 10]);
        $db = Database::getInstance();
        $db->prepare("UPDATE users SET password_hash = :password WHERE id = :id");
        $db->execute([':password' => $passwordHash, ':id' => $userId]);

        Security::logSecurityEvent('PASSWORD_CHANGED', ['user_id' => $userId]);
        Response::setFlash('success', 'Contraseña actualizada correctamente');
        Response::redirect(APP_URL . '/user/profile');
    }
}
