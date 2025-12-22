<?php
/**
 * AquariumController
 * Maneja módulo de acuarios del usuario
 */

class AquariumController {
    private $aquariumModel;
    private $fishModel;

    public function __construct() {
        $this->aquariumModel = new Aquarium();
        $this->fishModel = new Fish();
    }

    /**
     * Listar acuarios del usuario
     */
    public function index() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $aquariums = $this->aquariumModel->getByUser(Session::getUserId());
        $pageTitle = 'Mis Acuarios';
        require BASE_PATH . '/app/views/aquarium/index.php';
    }

    /**
     * Listar acuarios públicamente (sin autenticación)
     */
    public function publicIndex() {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 12;

        $aquariums = $this->aquariumModel->getPublic($page, $perPage);
        $totalAquariums = $this->aquariumModel->countPublic();
        $totalPages = ceil($totalAquariums / $perPage);

        $pageTitle = 'Acuarios Públicos';
        $isPublicView = true;
        require BASE_PATH . '/app/views/aquarium/public-index.php';
    }

    /**
     * Ver detalle de acuario
     */
    public function show() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $aquariumId = (int)$_GET['id'];
        $aquarium = $this->aquariumModel->getById($aquariumId);

        if (!$aquarium) {
            Response::notFound();
        }

        // Verificar permisos
        if ($aquarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        $fishes = $this->aquariumModel->getFishes($aquariumId);
        $plants = $this->aquariumModel->getPlants($aquariumId);
        $substrates = $this->aquariumModel->getSubstrates($aquariumId);
        $maintenanceLogs = $this->aquariumModel->getMaintenanceLogs($aquariumId);
        $gallery = $this->aquariumModel->getGallery($aquariumId);
        
        // Cargar peces disponibles para el formulario
        $availableFishes = $this->fishModel->getApproved('', '', 1, 1000);

        // CSRF
        $csrfToken = Security::generateCsrfToken();

        $pageTitle = $aquarium['name'];
        require BASE_PATH . '/app/views/aquarium/show.php';
    }

    /**
     * Ver acuario públicamente (sin autenticación)
     */
    public function publicShow() {
        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $aquariumId = (int)$_GET['id'];
        $aquarium = $this->aquariumModel->getById($aquariumId);

        if (!$aquarium) {
            Response::notFound();
        }

        // En vista pública, cargar información de lectura
        $fishes = $this->aquariumModel->getFishes($aquariumId);
        $plants = $this->aquariumModel->getPlants($aquariumId);
        $substrates = $this->aquariumModel->getSubstrates($aquariumId);
        $maintenanceLogs = $this->aquariumModel->getMaintenanceLogs($aquariumId);
        $gallery = $this->aquariumModel->getGallery($aquariumId);
        
        // Variable para saber si es vista pública (no mostrar botones de edición)
        $isPublicView = true;
        
        // Inicializar variables por defecto
        $isOwner = false;
        $availableFishes = [];
        $csrfToken = '';
        
        // Si el usuario está logueado y es propietario, cargar también peces disponibles para editar
        if (Session::isLogged() && $aquarium['user_id'] === Session::getUserId()) {
            $isOwner = true;
            $availableFishes = $this->fishModel->getApproved('', '', 1, 1000);
            $csrfToken = Security::generateCsrfToken();
        }

        $pageTitle = $aquarium['name'];
        require BASE_PATH . '/app/views/aquarium/show.php';
    }

    /**
     * Vista para crear acuario
     */
    public function createView() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $pageTitle = 'Nuevo Acuario';
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/aquarium/create.php';
    }

    /**
     * Crear acuario
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
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $name = Security::sanitize($_POST['name'] ?? '');
        if (empty($name)) {
            Response::json(['success' => false, 'message' => 'Nombre requerido'], 400);
        }

        try {
            $aquariumId = $this->aquariumModel->create([
                'user_id' => Session::getUserId(),
                'name' => $name,
                'description' => Security::sanitize($_POST['description'] ?? ''),
                'volume_liters' => (float)($_POST['volume_liters'] ?? 0),
                'type' => Security::sanitize($_POST['type'] ?? 'agua_dulce'),
                'dimensions_length' => (float)($_POST['dimensions_length'] ?? 0),
                'dimensions_width' => (float)($_POST['dimensions_width'] ?? 0),
                'dimensions_height' => (float)($_POST['dimensions_height'] ?? 0),
                'filter_type' => Security::sanitize($_POST['filter_type'] ?? ''),
                'lighting_hours' => (int)($_POST['lighting_hours'] ?? 8),
                'co2_injection' => isset($_POST['co2_injection'])
            ]);

            Security::logSecurityEvent('AQUARIUM_CREATED', ['aquarium_id' => $aquariumId, 'user_id' => Session::getUserId()]);
            Response::json(['success' => true, 'message' => 'Acuario creado!', 'aquarium_id' => $aquariumId]);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Agregar pez al acuario
     */
    public function addFish() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/aquarium/show?id=' . ($_POST['aquarium_id'] ?? ''));
        }

        $aquariumId = (int)($_POST['aquarium_id'] ?? 0);
        $fishId = (int)($_POST['fish_id'] ?? 0);
        $customName = trim(Security::sanitize($_POST['custom_common_name'] ?? ''));
        $customScientific = trim(Security::sanitize($_POST['custom_scientific_name'] ?? ''));
        $quantity = (int)($_POST['quantity'] ?? 1);

        // Validar que acuario pertenece al usuario
        $aquarium = $this->aquariumModel->getById($aquariumId);
        if (!$aquarium || $aquarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        // Si no se seleccionó un pez, intentar crear uno personalizado
        if ($fishId <= 0) {
            if (empty($customName)) {
                Response::setFlash('error', 'Selecciona un pez o ingresa un nombre');
                Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
            }

            // Crear ficha mínima aprobada para uso personal
            $newId = $this->fishModel->create([
                'common_name' => $customName,
                'scientific_name' => $customScientific ?: null,
                'status' => FISH_STATUS_APPROVED,
                'author_id' => Session::getUserId()
            ]);

            if (!$newId) {
                Response::setFlash('error', 'No se pudo crear el pez personalizado');
                Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
            }
            $fishId = (int)$newId;
        } else {
            // Verificar que pez está aprobado
            $fish = $this->fishModel->getById($fishId);
            if (!$fish || $fish['status'] !== FISH_STATUS_APPROVED) {
                Response::json(['success' => false, 'message' => 'Pez no válido'], 400);
            }
        }

        try {
            $this->aquariumModel->addFish($aquariumId, $fishId, $quantity);
            Response::setFlash('success', 'Pez agregado!');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        } catch (Exception $e) {
            Response::setFlash('error', 'Error: ' . $e->getMessage());
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }
    }

    /**
     * Agregar planta
     */
    public function addPlant() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $aquariumId = (int)($_POST['aquarium_id'] ?? 0);
        $name = Security::sanitize($_POST['name'] ?? '');

        $aquarium = $this->aquariumModel->getById($aquariumId);
        if (!$aquarium || $aquarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        if (empty($name)) {
            Response::json(['success' => false, 'message' => 'Nombre de planta requerido'], 400);
        }

        try {
            $this->aquariumModel->addPlant($aquariumId, [
                'name' => $name,
                'quantity' => (int)($_POST['quantity'] ?? 1),
                'care_level' => Security::sanitize($_POST['care_level'] ?? 'medio'),
                'lighting_requirement' => Security::sanitize($_POST['lighting_requirement'] ?? ''),
                'notes' => Security::sanitize($_POST['notes'] ?? '')
            ]);
            Response::json(['success' => true, 'message' => 'Planta agregada!']);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Registrar mantenimiento
     */
    public function logMaintenance() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $aquariumId = (int)($_POST['aquarium_id'] ?? 0);
        $logType = Security::sanitize($_POST['log_type'] ?? '');
        $reminderEnabled = !empty($_POST['reminder_enabled']);
        $reminderDays = (int)($_POST['reminder_days'] ?? 0);
        $reminderDaysCustom = (int)($_POST['reminder_days_custom'] ?? 0);
        $reminderDays = $reminderDaysCustom > 0 ? $reminderDaysCustom : $reminderDays;

        if ($reminderEnabled) {
            if ($reminderDays < 1 || $reminderDays > 365) {
                Response::setFlash('error', 'Define un intervalo de recordatorio entre 1 y 365 días');
                Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
            }
        }

        $aquarium = $this->aquariumModel->getById($aquariumId);
        if (!$aquarium || $aquarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        try {
            $nextAt = null;
            if ($reminderEnabled && $reminderDays > 0) {
                $nextAt = date('Y-m-d H:i:s', time() + ($reminderDays * 86400));
            }

            $this->aquariumModel->addMaintenanceLog($aquariumId, [
                'log_type' => $logType,
                'description' => Security::sanitize($_POST['description'] ?? ''),
                'percentage' => (int)($_POST['percentage'] ?? 0),
                'notes' => Security::sanitize($_POST['notes'] ?? ''),
                'reminder_enabled' => $reminderEnabled,
                'reminder_days' => $reminderDays ?: null,
                'reminder_next_at' => $nextAt
            ]);
            Response::setFlash('success', 'Registro de mantenimiento guardado!');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        } catch (Exception $e) {
            Response::setFlash('error', 'Error: ' . $e->getMessage());
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }
    }

    /**
     * Subir foto a la galería del acuario
     */
    public function uploadPhoto() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/aquarium/show?id=' . ($_POST['aquarium_id'] ?? ''));
        }

        $aquariumId = (int)($_POST['aquarium_id'] ?? 0);
        $aquarium = $this->aquariumModel->getById($aquariumId);
        if (!$aquarium || $aquarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            Response::setFlash('error', 'Debes seleccionar una imagen');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }

        if ($_FILES['photo']['size'] > MAX_UPLOAD_SIZE) {
            Response::setFlash('error', 'Archivo demasiado grande');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }

        if (!Security::validateMimeType($_FILES['photo']['tmp_name'], ALLOWED_IMAGE_TYPES)) {
            Response::setFlash('error', 'Tipo de imagen no permitido');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }

        $safeName = Security::generateSafeFilename($_FILES['photo']['name']);
        $destination = GALLERY_UPLOADS_PATH . '/' . $safeName;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
            Response::setFlash('error', 'No se pudo guardar la imagen');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }

        try {
            $this->aquariumModel->addGalleryImage(
                $aquariumId,
                $safeName,
                Security::sanitize($_POST['title'] ?? ''),
                Security::sanitize($_POST['description'] ?? '')
            );

            if (empty($aquarium['main_image'])) {
                $this->aquariumModel->update($aquariumId, ['main_image' => $safeName]);
            }

            Response::setFlash('success', 'Imagen subida');
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        } catch (Exception $e) {
            Response::setFlash('error', 'Error: ' . $e->getMessage());
            Response::redirect(APP_URL . '/aquarium/show?id=' . $aquariumId);
        }
    }

    /**
     * Eliminar acuario
     */
    /**
     * Alternar estado del acuario (activo/inactivo)
     */
    public function toggleStatus() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        $aquariumId = (int)($_POST['aquarium_id'] ?? 0);
        $aquarium = $this->aquariumModel->getById($aquariumId);

        if (!$aquarium) {
            Response::json(['success' => false, 'message' => 'Acuario no encontrado'], 404);
        }

        // Verificar propietario
        if ($aquarium['user_id'] != Session::getUserId()) {
            Response::json(['success' => false, 'message' => 'Acceso denegado'], 403);
        }

        try {
            // Cambiar estado
            $newStatus = $aquarium['status'] === 'activo' ? 'inactivo' : 'activo';
            $this->aquariumModel->update($aquariumId, ['status' => $newStatus]);

            Security::logSecurityEvent('AQUARIUM_STATUS_CHANGED', [
                'aquarium_id' => $aquariumId,
                'user_id' => Session::getUserId(),
                'old_status' => $aquarium['status'],
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

    public function delete() {
        if (!Session::isLogged() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::unauthorized();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::setFlash('error', 'Token inválido');
            Response::redirect(APP_URL . '/aquarium');
        }

        $aquariumId = (int)($_POST['aquarium_id'] ?? 0);
        $aquarium = $this->aquariumModel->getById($aquariumId);

        if (!$aquarium) {
            Response::setFlash('error', 'Acuario no encontrado');
            Response::redirect(APP_URL . '/aquarium');
        }

        // Verificar propietario
        if ($aquarium['user_id'] != Session::getUserId()) {
            Response::forbidden();
        }

        try {
            // Obtener galería para eliminar archivos
            $gallery = $this->aquariumModel->getGallery($aquariumId);
            foreach ($gallery as $photo) {
                $filePath = GALLERY_UPLOADS_PATH . '/' . $photo['image_path'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            // Eliminar acuario (cascada elimina peces, plantas, etc.)
            $this->aquariumModel->delete($aquariumId);
            Security::logSecurityEvent('AQUARIUM_DELETED', ['aquarium_id' => $aquariumId, 'user_id' => Session::getUserId()]);

            Response::setFlash('success', 'Acuario eliminado');
            Response::redirect(APP_URL . '/aquarium');
        } catch (Exception $e) {
            Response::setFlash('error', 'Error: ' . $e->getMessage());
            Response::redirect(APP_URL . '/aquarium');
        }
    }

    /**
     * Dashboard con estadísticas de acuarios
     */
    public function dashboard() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $userId = Session::getUserId();
        $statistics = $this->aquariumModel->getStatistics($userId);
        $alerts = $this->aquariumModel->getMaintenanceAlerts($userId);
        $recentMaintenance = $this->aquariumModel->getRecentMaintenance($userId, 5);
        $aquariums = $this->aquariumModel->getByUser($userId);

        $pageTitle = 'Dashboard de Acuarios';
        $contentView = BASE_PATH . '/app/views/aquarium/dashboard-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Buscar y filtrar acuarios
     */
    public function search() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $userId = Session::getUserId();
        $searchTerm = Security::sanitize($_GET['q'] ?? '');
        $type = Security::sanitize($_GET['type'] ?? '');
        $status = Security::sanitize($_GET['status'] ?? '');

        // DEBUG
        error_log("SEARCH DEBUG: q='$searchTerm', type='$type', status='$status'");
        error_log("SEARCH CONDITION: " . ((!empty($searchTerm) || !empty($type) || !empty($status)) ? 'search()' : 'getByUser()'));

        if (!empty($searchTerm) || !empty($type) || !empty($status)) {
            $aquariums = $this->aquariumModel->search($userId, $searchTerm, $type, $status);
            error_log("SEARCH RESULT: " . count($aquariums) . " aquariums");
        } else {
            $aquariums = $this->aquariumModel->getByUser($userId);
            error_log("GETBYUSER RESULT: " . count($aquariums) . " aquariums");
        }

        $pageTitle = 'Buscar Acuarios';
        $contentView = BASE_PATH . '/app/views/aquarium/search-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Galería pública de acuarios
     */
    public function gallery() {
        $page = (int)($_GET['page'] ?? 1);
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $galleries = $this->aquariumModel->getAllGalleries($limit, $offset);
        
        $pageTitle = 'Galería Pública de Acuarios';
        $contentView = BASE_PATH . '/app/views/aquarium/gallery-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Exportar acuario a PDF (placeholder)
     */
    public function exportPDF() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $aquariumId = (int)($_GET['id'] ?? 0);
        $aquarium = $this->aquariumModel->getById($aquariumId);

        if (!$aquarium || $aquarium['user_id'] != Session::getUserId()) {
            Response::notFound();
        }

        Response::json([
            'success' => true,
            'data' => $aquarium,
            'message' => 'Funcionalidad de PDF en desarrollo'
        ]);
    }
}
