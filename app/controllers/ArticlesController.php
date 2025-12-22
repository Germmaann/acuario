<?php
/**
 * ArticlesController
 */
class ArticlesController {
    
    /**
     * Listar todos los artículos publicados
     */
    public function index() {
        $articleModel = new Article();
        
        // Paginación
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $articles = $articleModel->getAll($perPage, $offset);
        $total = $articleModel->countAll();
        $totalPages = ceil($total / $perPage);
        
        $contentView = BASE_PATH . '/app/views/articles/index-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    
    /**
     * Ver artículo individual
     */
    public function show() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            Response::redirect(APP_URL . '/articles');
        }
        
        $id = (int)$_GET['id'];
        $articleModel = new Article();
        $article = $articleModel->getById($id);
        
        if (!$article) {
            Response::notFound();
        }
        
        $contentView = BASE_PATH . '/app/views/articles/show-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    
    /**
     * Filtrar por categoría
     */
    public function byCategory() {
        if (!isset($_GET['category']) || empty($_GET['category'])) {
            Response::redirect(APP_URL . '/articles');
        }
        
        $category = $_GET['category'];
        $validCategories = ['DIY', 'Blog', 'Evento'];
        
        if (!in_array($category, $validCategories)) {
            Response::redirect(APP_URL . '/articles');
        }
        
        $articleModel = new Article();
        
        // Paginación
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $articles = $articleModel->getByCategory($category, $perPage, $offset);
        $total = $articleModel->countByCategory($category);
        $totalPages = ceil($total / $perPage);
        
        $contentView = BASE_PATH . '/app/views/articles/category-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    
    /**
     * Crear artículo (solo autenticados y admin)
     */
    public function createView() {
        if (!Session::isAuthenticated()) {
            Response::redirect(APP_URL . '/auth/login');
        }
        
        if (Session::get('role_id') != 1) { // Solo admin
            Response::forbidden();
        }
        
        $contentView = BASE_PATH . '/app/views/articles/create-content.php';
        require BASE_PATH . '/app/views/layouts/main.php';
    }
    
    /**
     * Guardar artículo
     */
    public function create() {
        if (!Session::isAuthenticated()) {
            Response::json(['success' => false, 'message' => 'No autenticado']);
        }
        
        if (Session::get('role_id') != 1) { // Solo admin
            Response::json(['success' => false, 'message' => 'No autorizado']);
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Response::json(['success' => false, 'message' => 'Método no permitido']);
        }
        
        // Validar CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== Session::get('csrf_token')) {
            Response::json(['success' => false, 'message' => 'Token inválido']);
        }
        
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $content = $_POST['content'] ?? '';
        $category = $_POST['category'] ?? 'Blog';
        $isPublished = isset($_POST['is_published']) ? 1 : 0;
        
        // Validar
        if (empty($title) || empty($content)) {
            Response::json(['success' => false, 'message' => 'Faltan campos requeridos']);
        }
        
        $articleModel = new Article();
        $imagePath = null;
        
        // Subir imagen si existe
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $imagePath = Security::uploadFile($_FILES['image'], 'articles');
            if (!$imagePath) {
                Response::json(['success' => false, 'message' => 'Error al subir imagen']);
            }
        }
        
        $articleId = $articleModel->create(
            Session::get('user_id'),
            $title,
            $description,
            $content,
            $category,
            $imagePath
        );
        
        if (!$articleId) {
            Response::json(['success' => false, 'message' => 'Error al crear artículo']);
        }
        
        // Publicar si está seleccionado
        if ($isPublished) {
            $articleModel->publish($articleId);
        }
        
        Response::json([
            'success' => true,
            'message' => 'Artículo creado exitosamente',
            'article_id' => $articleId
        ]);
    }
    
    /**
     * Actualizar artículo
     */
    public function update() {
        if (!Session::isAuthenticated()) {
            Response::json(['success' => false, 'message' => 'No autenticado']);
        }
        
        if (Session::get('role_id') != 1) {
            Response::json(['success' => false, 'message' => 'No autorizado']);
        }
        
        $id = $_POST['id'] ?? 0;
        if (!$id) {
            Response::json(['success' => false, 'message' => 'ID inválido']);
        }
        
        $articleModel = new Article();
        $article = $articleModel->getByIdAdmin($id);
        
        if (!$article) {
            Response::json(['success' => false, 'message' => 'Artículo no encontrado']);
        }
        
        $title = $_POST['title'] ?? $article['title'];
        $description = $_POST['description'] ?? $article['description'];
        $content = $_POST['content'] ?? $article['content'];
        $category = $_POST['category'] ?? $article['category'];
        $isPublished = isset($_POST['is_published']) ? 1 : 0;
        
        $imagePath = $article['image_path'];
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            if ($imagePath) {
                @unlink(BASE_PATH . '/public/uploads/articles/' . $imagePath);
            }
            $imagePath = Security::uploadFile($_FILES['image'], 'articles');
            if (!$imagePath) {
                Response::json(['success' => false, 'message' => 'Error al subir imagen']);
            }
        }
        
        if (!$articleModel->update($id, $title, $description, $content, $category, $imagePath, $isPublished)) {
            Response::json(['success' => false, 'message' => 'Error al actualizar']);
        }
        
        Response::json(['success' => true, 'message' => 'Artículo actualizado']);
    }
    
    /**
     * Eliminar artículo
     */
    public function delete() {
        if (!Session::isAuthenticated()) {
            Response::json(['success' => false, 'message' => 'No autenticado']);
        }
        
        if (Session::get('role_id') != 1) {
            Response::json(['success' => false, 'message' => 'No autorizado']);
        }
        
        $id = $_POST['id'] ?? 0;
        if (!$id) {
            Response::json(['success' => false, 'message' => 'ID inválido']);
        }
        
        $articleModel = new Article();
        $article = $articleModel->getByIdAdmin($id);
        
        if (!$article) {
            Response::json(['success' => false, 'message' => 'Artículo no encontrado']);
        }
        
        // Eliminar imagen
        if ($article['image_path']) {
            @unlink(BASE_PATH . '/public/uploads/articles/' . $article['image_path']);
        }
        
        if (!$articleModel->delete($id)) {
            Response::json(['success' => false, 'message' => 'Error al eliminar']);
        }
        
        Response::json(['success' => true, 'message' => 'Artículo eliminado']);
    }
}
