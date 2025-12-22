<?php
/**
 * TerrariumController
 * Maneja módulo de terrarios del usuario
 */

class TerrariumController {
    private $terrariumModel;

    public function __construct() {
        $this->terrariumModel = new Terrarium();
    }

    /**
     * Listar terrarios del usuario
     */
    public function index() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $terrariums = $this->terrariumModel->getByUser(Session::getUserId());
        $pageTitle = 'Mis Terrarios';
        require BASE_PATH . '/app/views/terrarium/index.php';
    }

    /**
     * Listar terrarios públicamente (sin autenticación)
     */
    public function publicIndex() {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 12;

        $terrariums = $this->terrariumModel->getPublic($page, $perPage);
        $totalTerrariums = $this->terrariumModel->countPublic();
        $totalPages = ceil($totalTerrariums / $perPage);

        $pageTitle = 'Terrarios Públicos';
        $isPublicView = true;
        require BASE_PATH . '/app/views/terrarium/public-index.php';
    }

    /**
     * Ver detalle de terrario
     */
    public function show() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $terrariumId = (int)$_GET['id'];
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium) {
            Response::notFound();
        }

        // Verificar permisos
        if ($terrarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        $inhabitants = $this->terrariumModel->getInhabitants($terrariumId);
        $maintenanceLogs = $this->terrariumModel->getMaintenanceLogs($terrariumId);
        $gallery = $this->terrariumModel->getGallery($terrariumId);

        // CSRF
        $csrfToken = Security::generateCsrfToken();

        $pageTitle = $terrarium['name'];
        require BASE_PATH . '/app/views/terrarium/show.php';
    }

    /**
     * Ver terrario públicamente (sin autenticación)
     */
    public function publicShow() {
        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $terrariumId = (int)$_GET['id'];
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium) {
            Response::notFound();
        }

        // En vista pública, cargar información de lectura
        $inhabitants = $this->terrariumModel->getInhabitants($terrariumId);
        $maintenanceLogs = $this->terrariumModel->getMaintenanceLogs($terrariumId);
        $gallery = $this->terrariumModel->getGallery($terrariumId);
        
        // Variable para saber si es vista pública
        $isPublicView = true;
        
        // Inicializar variables por defecto
        $isOwner = false;
        $csrfToken = '';
        
        // Si el usuario está logueado y es propietario, permitir edición
        if (Session::isLogged() && $terrarium['user_id'] === Session::getUserId()) {
            $isOwner = true;
            $csrfToken = Security::generateCsrfToken();
        }

        $pageTitle = $terrarium['name'];
        require BASE_PATH . '/app/views/terrarium/show.php';
    }

    /**
     * Vista para crear terrario
     */
    public function createView() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $pageTitle = 'Nuevo Terrario';
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/terrarium/create.php';
    }

    /**
     * Crear terrario
     */
    public function create() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Método no permitido');
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/terrarium/create');
        }

        $name = Security::sanitize($_POST['name'] ?? '');
        if (empty($name)) {
            Response::setFlash('error', 'Nombre requerido');
            Response::redirect(APP_URL . '/terrarium/create');
        }

        try {
            $terrariumId = $this->terrariumModel->create([
                'user_id' => Session::getUserId(),
                'name' => $name,
                'description' => Security::sanitize($_POST['description'] ?? ''),
                'volume_liters' => (float)($_POST['volume_liters'] ?? 0),
                'type' => Security::sanitize($_POST['type'] ?? 'tropical'),
                'dimensions_length' => (float)($_POST['length'] ?? 0),
                'dimensions_width' => (float)($_POST['width'] ?? 0),
                'dimensions_height' => (float)($_POST['height'] ?? 0),
                'lighting_hours' => (int)($_POST['lighting_hours'] ?? 8),
                'heating_type' => Security::sanitize($_POST['heating_type'] ?? ''),
                'humidity_level' => (int)($_POST['humidity_level'] ?? 50),
                'temperature_min' => (float)($_POST['temperature_min'] ?? 0),
                'temperature_max' => (float)($_POST['temperature_max'] ?? 0),
                'status' => Security::sanitize($_POST['status'] ?? 'en_construcción')
            ]);

            Security::logSecurityEvent('TERRARIUM_CREATED', ['terrarium_id' => $terrariumId, 'user_id' => Session::getUserId()]);
            Response::setFlash('success', 'Terrario creado exitosamente!');
            Response::redirect(APP_URL . '/terrarium/show?id=' . $terrariumId);
        } catch (Exception $e) {
            Response::setFlash('error', 'Error al crear terrario: ' . $e->getMessage());
            Response::redirect(APP_URL . '/terrarium/create');
        }
    }

    /**
     * Agregar habitante al terrario
     */
    public function addInhabitant() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/terrarium/show?id=' . ($_POST['terrarium_id'] ?? ''));
        }

        $terrariumId = (int)($_POST['terrarium_id'] ?? 0);
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium || $terrarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        $this->terrariumModel->addInhabitant($terrariumId, [
            'name' => Security::sanitize($_POST['name'] ?? ''),
            'type' => Security::sanitize($_POST['type'] ?? ''),
            'quantity' => (int)($_POST['quantity'] ?? 1),
            'notes' => Security::sanitize($_POST['notes'] ?? '')
        ]);

        Response::setFlash('success', 'Habitante agregado');
        Response::redirect(APP_URL . '/terrarium/show?id=' . $terrariumId);
    }

    /**
     * Agregar registro de mantenimiento
     */
    public function logMaintenance() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/terrarium/show?id=' . ($_POST['terrarium_id'] ?? ''));
        }

        $terrariumId = (int)($_POST['terrarium_id'] ?? 0);
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium || $terrarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        $this->terrariumModel->addMaintenanceLog($terrariumId, [
            'log_type' => Security::sanitize($_POST['log_type'] ?? ''),
            'description' => Security::sanitize($_POST['description'] ?? ''),
            'reminder_enabled' => isset($_POST['reminder_enabled']),
            'reminder_days' => (int)($_POST['reminder_days'] ?? 0)
        ]);

        Response::setFlash('success', 'Registro de mantenimiento agregado');
        Response::redirect(APP_URL . '/terrarium/show?id=' . $terrariumId);
    }

    /**
     * Alternar estado del terrario (activo/inactivo)
     */
    public function toggleStatus() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $terrariumId = (int)($_POST['terrarium_id'] ?? 0);
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium) {
            Response::json(['success' => false, 'message' => 'Terrario no encontrado'], 404);
        }

        // Verificar propietario
        if ($terrarium['user_id'] != Session::getUserId()) {
            Response::json(['success' => false, 'message' => 'Acceso denegado'], 403);
        }

        try {
            // Cambiar estado
            $newStatus = $terrarium['status'] === 'activo' ? 'inactivo' : 'activo';
            $this->terrariumModel->update($terrariumId, ['status' => $newStatus]);

            Security::logSecurityEvent('TERRARIUM_STATUS_CHANGED', [
                'terrarium_id' => $terrariumId,
                'user_id' => Session::getUserId(),
                'old_status' => $terrarium['status'],
                'new_status' => $newStatus
            ]);

            Response::json([
                'success' => true,
                'message' => 'Estado actualizado',
                'status' => $newStatus
            ]);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Eliminar terrario
     */
    public function delete() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/terrarium');
        }

        $terrariumId = (int)($_POST['terrarium_id'] ?? 0);
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium) {
            Response::setFlash('error', 'Terrario no encontrado');
            Response::redirect(APP_URL . '/terrarium');
        }

        // Verificar propietario
        if ($terrarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        try {
            $this->terrariumModel->delete($terrariumId);
            Security::logSecurityEvent('TERRARIUM_DELETED', ['terrarium_id' => $terrariumId, 'user_id' => Session::getUserId()]);

            Response::setFlash('success', 'Terrario eliminado');
            Response::redirect(APP_URL . '/terrarium');
        } catch (Exception $e) {
            Response::setFlash('error', 'Error: ' . $e->getMessage());
            Response::redirect(APP_URL . '/terrarium');
        }
    }

    /**
     * Dashboard con estadísticas
     */
    public function dashboard() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $userId = Session::getUserId();
        $statistics = $this->terrariumModel->getStatistics($userId);
        $alerts = $this->terrariumModel->getMaintenanceAlerts($userId);
        $recentMaintenance = $this->terrariumModel->getRecentMaintenance($userId, 5);
        $terrariums = $this->terrariumModel->getByUser($userId);

        $pageTitle = 'Dashboard de Terrarios';
        $contentView = BASE_PATH . '/app/views/terrarium/dashboard-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Buscar y filtrar terrarios
     */
    public function search() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $userId = Session::getUserId();
        $searchTerm = Security::sanitize($_GET['q'] ?? '');
        $type = Security::sanitize($_GET['type'] ?? '');
        $status = Security::sanitize($_GET['status'] ?? '');

        if (!empty($searchTerm) || !empty($type) || !empty($status)) {
            $terrariums = $this->terrariumModel->search($userId, $searchTerm, $type, $status);
        } else {
            $terrariums = $this->terrariumModel->getByUser($userId);
        }

        $pageTitle = 'Buscar Terrarios';
        $contentView = BASE_PATH . '/app/views/terrarium/search-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Galería pública de usuarios
     */
    public function gallery() {
        $page = (int)($_GET['page'] ?? 1);
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $galleries = $this->terrariumModel->getAllGalleries($limit, $offset + 1);
        
        $pageTitle = 'Galería Pública de Terrarios';
        $contentView = BASE_PATH . '/app/views/terrarium/gallery-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Exportar terrario a PDF
     */
    public function exportPDF() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $terrariumId = (int)($_GET['id'] ?? 0);
        $terrarium = $this->terrariumModel->getById($terrariumId);

        if (!$terrarium || $terrarium['user_id'] != Session::getUserId()) {
            Response::notFound();
        }

        // Aquí iría la lógica para generar PDF
        // Por ahora devolvemos JSON con los datos
        Response::json([
            'success' => true,
            'data' => $terrarium,
            'message' => 'Funcionalidad de PDF en desarrollo'
        ]);
    }
}

