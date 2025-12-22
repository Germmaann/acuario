<?php
/**
 * AdminController
 * Panel administrativo
 */

class AdminController {
    private $userModel;
    private $fishModel;
    private $reportModel;
    private $aquariumModel;

    public function __construct() {
        $this->userModel = new User();
        $this->fishModel = new Fish();
        $this->reportModel = new Report();
        $this->aquariumModel = new Aquarium();

        // Verificar que sea admin
        if (!Session::isAdmin()) {
            Response::forbidden();
        }
    }

    /**
     * Dashboard admin
     */
    public function dashboard() {
        $stats = [
            'total_users' => $this->userModel->count(),
            'pending_fish' => $this->fishModel->countApproved('', ''), // Adaptado
            'reports' => $this->reportModel->count(),
            'new_reports' => $this->reportModel->count(REPORT_STATUS_NEW)
        ];

        $pageTitle = 'Panel Administrativo';
        require BASE_PATH . '/app/views/admin/dashboard.php';
    }

    /**
     * Moderación de peces
     */
    public function moderateFish() {
        $page = (int)($_GET['page'] ?? 1);
        $filter = $_GET['filter'] ?? 'pendiente';
        
        // Validar filtro
        $validFilters = ['pendiente', 'aprobado', 'rechazado', 'todos'];
        if (!in_array($filter, $validFilters)) {
            $filter = 'pendiente';
        }
        
        // Obtener peces según filtro
        if ($filter === 'todos') {
            $fishes = $this->fishModel->getAll($page, 20);
        } elseif ($filter === 'pendiente') {
            $fishes = $this->fishModel->getPending($page, 20);
        } elseif ($filter === 'aprobado') {
            $fishes = $this->fishModel->getApproved('', '', $page, 20);
        } else { // rechazado
            $fishes = $this->fishModel->getRejected($page, 20);
        }
        
        // Contar por estado
        $counts = [
            'pendiente' => $this->fishModel->countByStatus('pendiente'),
            'aprobado' => $this->fishModel->countByStatus('aprobado'),
            'rechazado' => $this->fishModel->countByStatus('rechazado'),
            'todos' => $this->fishModel->countByStatus('')
        ];

        $pageTitle = 'Moderación de Peces';
        require BASE_PATH . '/app/views/admin/moderate-fish.php';
    }

    /**
     * Aprobar/Rechazar pez
     */
    public function updateFishStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $fishId = (int)($_POST['fish_id'] ?? 0);
        $status = Security::sanitize($_POST['status'] ?? '');
        $reason = Security::sanitize($_POST['reason'] ?? '');

        if (!in_array($status, [FISH_STATUS_APPROVED, FISH_STATUS_REJECTED, FISH_STATUS_PENDING])) {
            Response::json(['success' => false, 'message' => 'Estado inválido'], 400);
        }

        try {
            $this->fishModel->update($fishId, [
                'status' => $status,
                'rejection_reason' => $status === FISH_STATUS_REJECTED ? $reason : null
            ]);

            $this->fishModel->logEdit($fishId, Session::getUserId(), ['status' => $status], 'Moderación: ' . $reason);
            
            Security::logSecurityEvent('FISH_MODERATED', [
                'fish_id' => $fishId,
                'admin_id' => Session::getUserId(),
                'status' => $status
            ]);

            Response::json(['success' => true, 'message' => 'Pez actualizado!']);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Gestión de reportes
     */
    public function reports() {
        $page = (int)($_GET['page'] ?? 1);
        $status = Security::sanitize($_GET['status'] ?? '');
        
        $reports = $this->reportModel->getAll($status, $page, 10);
        $stats = $this->reportModel->getStatistics();

        $pageTitle = 'Reportes';
        require BASE_PATH . '/app/views/admin/reports.php';
    }

    /**
     * Actualizar estado de reporte
     */
    public function updateReportStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $reportId = (int)($_POST['report_id'] ?? 0);
        $status = Security::sanitize($_POST['status'] ?? '');
        $response = Security::sanitize($_POST['response'] ?? '');

        try {
            $this->reportModel->updateStatus($reportId, $status, Session::getUserId(), $response);
            Response::json(['success' => true, 'message' => 'Reporte actualizado!']);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Gestión de usuarios
     */
    public function users() {
        $page = (int)($_GET['page'] ?? 1);
        $users = $this->userModel->getAll($page, 10);
        $totalUsers = $this->userModel->count();
        $totalPages = ceil($totalUsers / 10);

        // Obtener roles disponibles
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, name FROM roles ORDER BY name");
        $stmt->execute();
        $roles = $stmt->fetchAll();

        $csrfToken = Security::generateCsrfToken();
        $pageTitle = 'Gestión de Usuarios';
        require BASE_PATH . '/app/views/admin/users.php';
    }

    /**
     * Cambiar rol de usuario
     */
    public function changeUserRole() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $userId = (int)($_POST['user_id'] ?? 0);
        $roleId = (int)($_POST['role_id'] ?? 0);

        if ($userId === Session::getUserId()) {
            Response::json(['success' => false, 'message' => 'No puedes cambiar tu propio rol'], 400);
        }

        try {
            $this->userModel->update($userId, ['role_id' => $roleId]);
            Response::json(['success' => true, 'message' => 'Rol actualizado!']);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Toggle estado de usuario (activar/desactivar)
     */
    public function deactivateUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $userId = (int)($_POST['user_id'] ?? 0);

        if ($userId === Session::getUserId()) {
            Response::json(['success' => false, 'message' => 'No puedes cambiar tu propio estado'], 400);
        }

        try {
            // Obtener estado actual del usuario
            $user = $this->userModel->getById($userId);
            if (!$user) {
                Response::json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            // Toggle el estado
            $newState = !$user['is_active'];
            $this->userModel->setActive($userId, $newState);
            
            $message = $newState ? 'Usuario activado!' : 'Usuario desactivado!';
            Response::json(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar usuario
     */
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $userId = (int)($_POST['user_id'] ?? 0);

        if ($userId === Session::getUserId()) {
            Response::json(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta'], 400);
        }

        try {
            // Obtener usuario para verificar existencia
            $user = $this->userModel->getById($userId);
            if (!$user) {
                Response::json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }

            // Eliminar usuario
            $this->userModel->delete($userId);
            Security::logSecurityEvent('USER_DELETED', ['deleted_user_id' => $userId, 'username' => $user['username']]);
            
            Response::json(['success' => true, 'message' => 'Usuario eliminado!']);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
