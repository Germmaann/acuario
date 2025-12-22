<?php
/**
 * FishController
 * Maneja la wiki de peces
 */

class FishController {
    private $fishModel;
    private $userModel;
    private $reportModel;

    public function __construct() {
        $this->fishModel = new Fish();
        $this->userModel = new User();
        $this->reportModel = new Report();
    }

    /**
     * Listar peces aprobados
     */
    public function index() {
        try {
            $page = (int)($_GET['page'] ?? 1);
            $search = Security::sanitize($_GET['search'] ?? '');
            $difficulty = Security::sanitize($_GET['difficulty'] ?? '');

            $fishes = $this->fishModel->getApproved($search, $difficulty, $page, 12);
            $totalFishes = $this->fishModel->countApproved($search, $difficulty);
            $totalPages = ceil($totalFishes / 12);

            $pageTitle = 'Wiki de Peces';
            require BASE_PATH . '/app/views/fish/index.php';
        } catch (Exception $e) {
            die('Error en FishController: ' . $e->getMessage());
        }
    }

    /**
     * Ver detalle de pez
     */
    public function show() {
        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $fishId = (int)$_GET['id'];
        $fish = $this->fishModel->getById($fishId);

        if (!$fish || $fish['status'] !== FISH_STATUS_APPROVED) {
            Response::notFound();
        }

        $images = $this->fishModel->getImages($fishId);
        $reports = $this->fishModel->getEditHistory($fishId);
        $userReports = [];

        // Si usuario logueado, obtener reportes que hizo
        if (Session::isLogged()) {
            $userReports = $this->reportModel->getByFish($fishId);
            $userReports = array_filter($userReports, function($r) {
                return $r['reporter_id'] == Session::getUserId();
            });
        }

        $pageTitle = $fish['common_name'];
        require BASE_PATH . '/app/views/fish/show.php';
    }

    /**
     * Vista para crear ficha de pez
     */
    public function createView() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $pageTitle = 'Crear Ficha de Pez';
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/fish/create.php';
    }

    /**
     * Procesar creación de ficha
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

        // Validaciones básicas
        $commonName = Security::sanitize($_POST['common_name'] ?? '');
        if (empty($commonName)) {
            Response::json(['success' => false, 'message' => 'Nombre común requerido'], 400);
        }

        // Procesar imagen principal
        $mainImage = null;
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['main_image']['size'] > MAX_UPLOAD_SIZE) {
                Response::json(['success' => false, 'message' => 'Archivo muy grande'], 400);
            }

            if (!Security::validateMimeType($_FILES['main_image']['tmp_name'], ALLOWED_IMAGE_TYPES)) {
                Response::json(['success' => false, 'message' => 'Tipo de archivo no permitido'], 400);
            }

            $mainImage = Security::generateSafeFilename($_FILES['main_image']['name']);
            $tmpPath = FISH_UPLOADS_PATH . '/' . $mainImage;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $tmpPath);

        }

        // Crear ficha
        try {
            $fishId = $this->fishModel->create([
                'common_name' => $commonName,
                'scientific_name' => Security::sanitize($_POST['scientific_name'] ?? ''),
                'family' => Security::sanitize($_POST['family'] ?? ''),
                'origin' => Security::sanitize($_POST['origin'] ?? ''),
                'size_min' => (float)($_POST['size_min'] ?? 0),
                'size_max' => (float)($_POST['size_max'] ?? 0),
                'temperature_min' => (float)($_POST['temperature_min'] ?? 24),
                'temperature_max' => (float)($_POST['temperature_max'] ?? 26),
                'ph_min' => (float)($_POST['ph_min'] ?? 6.5),
                'ph_max' => (float)($_POST['ph_max'] ?? 7.5),
                'hardness_min' => (float)($_POST['hardness_min'] ?? 5),
                'hardness_max' => (float)($_POST['hardness_max'] ?? 20),
                'behavior' => Security::sanitize($_POST['behavior'] ?? ''),
                'compatibility' => Security::sanitize($_POST['compatibility'] ?? ''),
                'difficulty' => Security::sanitize($_POST['difficulty'] ?? DIFFICULTY_MEDIUM),
                'feeding' => Security::sanitize($_POST['feeding'] ?? ''),
                'lifespan' => (int)($_POST['lifespan'] ?? 0),
                'description' => Security::sanitize($_POST['description'] ?? ''),
                'main_image' => $mainImage,
                'status' => FISH_STATUS_PENDING,
                'author_id' => Session::getUserId()
            ]);

            if (!$fishId) {
                throw new Exception('Error al crear ficha');
            }

            Security::logSecurityEvent('FISH_CREATED', ['fish_id' => $fishId, 'user_id' => Session::getUserId()]);
            Response::json(['success' => true, 'message' => 'Ficha creada. Pendiente de aprobación.', 'fish_id' => $fishId]);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Vista para editar ficha
     */
    public function editView() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        if (!isset($_GET['id'])) {
            Response::notFound();
        }

        $fishId = (int)$_GET['id'];
        $fish = $this->fishModel->getById($fishId);

        if (!$fish) {
            Response::notFound();
        }

        // Verificar permisos
        if ($fish['author_id'] != Session::getUserId() && !Session::isAdmin()) {
            Response::forbidden();
        }

        $pageTitle = 'Editar: ' . $fish['common_name'];
        $csrfToken = Security::generateCsrfToken();
        require BASE_PATH . '/app/views/fish/edit.php';
    }

    /**
     * Actualizar ficha
     */
    public function update() {
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

        $fishId = (int)($_POST['fish_id'] ?? 0);
        $fish = $this->fishModel->getById($fishId);
        if (!$fish) {
            Response::json(['success' => false, 'message' => 'Pez no encontrado'], 404);
        }

        if ($fish['author_id'] != Session::getUserId() && !Session::isAdmin()) {
            Response::forbidden();
        }

        $commonName = Security::sanitize($_POST['common_name'] ?? '');
        if (empty($commonName)) {
            Response::json(['success' => false, 'message' => 'Nombre común requerido'], 400);
        }

        // Procesar imagen principal si llega
        $mainImage = $fish['main_image'] ?? null;
        if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['main_image']['size'] > MAX_UPLOAD_SIZE) {
                Response::json(['success' => false, 'message' => 'Archivo muy grande'], 400);
            }

            if (!Security::validateMimeType($_FILES['main_image']['tmp_name'], ALLOWED_IMAGE_TYPES)) {
                Response::json(['success' => false, 'message' => 'Tipo de archivo no permitido'], 400);
            }

            $safeName = Security::generateSafeFilename($_FILES['main_image']['name']);
            $tmpPath = FISH_UPLOADS_PATH . '/' . $safeName;
            if (!move_uploaded_file($_FILES['main_image']['tmp_name'], $tmpPath)) {
                Response::json(['success' => false, 'message' => 'No se pudo guardar la imagen'], 500);
            }
            $mainImage = $safeName;
        }

        try {
            $this->fishModel->update($fishId, [
                'common_name' => $commonName,
                'scientific_name' => Security::sanitize($_POST['scientific_name'] ?? ''),
                'family' => Security::sanitize($_POST['family'] ?? ''),
                'origin' => Security::sanitize($_POST['origin'] ?? ''),
                'size_min' => (float)($_POST['size_min'] ?? null),
                'size_max' => (float)($_POST['size_max'] ?? null),
                'temperature_min' => (float)($_POST['temperature_min'] ?? null),
                'temperature_max' => (float)($_POST['temperature_max'] ?? null),
                'ph_min' => (float)($_POST['ph_min'] ?? null),
                'ph_max' => (float)($_POST['ph_max'] ?? null),
                'hardness_min' => (float)($_POST['hardness_min'] ?? null),
                'hardness_max' => (float)($_POST['hardness_max'] ?? null),
                'behavior' => Security::sanitize($_POST['behavior'] ?? ''),
                'compatibility' => Security::sanitize($_POST['compatibility'] ?? ''),
                'difficulty' => Security::sanitize($_POST['difficulty'] ?? DIFFICULTY_MEDIUM),
                'feeding' => Security::sanitize($_POST['feeding'] ?? ''),
                'lifespan' => (int)($_POST['lifespan'] ?? 0),
                'description' => Security::sanitize($_POST['description'] ?? ''),
                'main_image' => $mainImage
            ]);

            Response::json(['success' => true, 'message' => 'Ficha actualizada', 'fish_id' => $fishId]);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Reportar error en ficha
     */
    public function report() {
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

        $fishId = (int)($_POST['fish_id'] ?? 0);
        $reportType = Security::sanitize($_POST['report_type'] ?? '');
        $comment = Security::sanitize($_POST['comment'] ?? '');

        if ($fishId <= 0 || empty($reportType) || empty($comment)) {
            Response::json(['success' => false, 'message' => 'Datos incompletos'], 400);
        }

        // Verificar que pez existe
        $fish = $this->fishModel->getById($fishId);
        if (!$fish) {
            Response::json(['success' => false, 'message' => 'Pez no encontrado'], 404);
        }

        // Verificar si ya reportó
        if ($this->reportModel->hasUserReported($fishId, Session::getUserId())) {
            Response::json(['success' => false, 'message' => 'Ya has reportado este pez'], 400);
        }

        try {
            $reportId = $this->reportModel->create([
                'fish_id' => $fishId,
                'reporter_id' => Session::getUserId(),
                'report_type' => $reportType,
                'comment' => $comment
            ]);

            Security::logSecurityEvent('FISH_REPORTED', ['fish_id' => $fishId, 'user_id' => Session::getUserId()]);
            Response::json(['success' => true, 'message' => 'Reporte enviado. Gracias!']);
        } catch (Exception $e) {
            Response::json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
