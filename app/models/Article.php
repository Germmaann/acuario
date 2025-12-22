<?php
/**
 * Article Model
 */
class Article {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Obtener todos los artículos publicados
     */
    public function getAll($limit = 12, $offset = 0) {
        $this->db->prepare("
            SELECT a.*, u.username, u.avatar_path
            FROM articles a
            JOIN users u ON a.author_id = u.id
            WHERE a.is_published = TRUE
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $this->db->execute([
            ':limit' => $limit,
            ':offset' => $offset
        ]);
        return $this->db->fetchAll();
    }

    /**
     * Contar artículos publicados
     */
    public function countAll() {
        $this->db->prepare("SELECT COUNT(*) as total FROM articles WHERE is_published = TRUE");
        $this->db->execute();
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Obtener artículos por categoría
     */
    public function getByCategory($category, $limit = 12, $offset = 0) {
        $this->db->prepare("
            SELECT a.*, u.username, u.avatar_path
            FROM articles a
            JOIN users u ON a.author_id = u.id
            WHERE a.is_published = TRUE AND a.category = :category
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $this->db->execute([
            ':category' => $category,
            ':limit' => $limit,
            ':offset' => $offset
        ]);
        return $this->db->fetchAll();
    }

    /**
     * Contar artículos por categoría
     */
    public function countByCategory($category) {
        $this->db->prepare("
            SELECT COUNT(*) as total FROM articles 
            WHERE is_published = TRUE AND category = :category
        ");
        $this->db->execute([':category' => $category]);
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Obtener últimos N artículos (para home)
     */
    public function getLatest($limit = 6) {
        $this->db->prepare("
            SELECT a.*, u.username, u.avatar_path
            FROM articles a
            JOIN users u ON a.author_id = u.id
            WHERE a.is_published = TRUE
            ORDER BY a.created_at DESC
            LIMIT :limit
        ");
        $this->db->execute([':limit' => $limit]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener artículo por ID
     */
    public function getById($id) {
        $this->db->prepare("
            SELECT a.*, u.username, u.avatar_path, u.id as author_id
            FROM articles a
            JOIN users u ON a.author_id = u.id
            WHERE a.id = :id AND a.is_published = TRUE
        ");
        $this->db->execute([':id' => $id]);
        $article = $this->db->fetch();
        
        if ($article) {
            // Incrementar vistas
            $this->incrementViews($id);
        }
        
        return $article;
    }

    /**
     * Obtener artículo sin publicar (admin)
     */
    public function getByIdAdmin($id) {
        $this->db->prepare("
            SELECT a.*, u.username, u.avatar_path, u.id as author_id
            FROM articles a
            JOIN users u ON a.author_id = u.id
            WHERE a.id = :id
        ");
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }

    /**
     * Crear artículo
     */
    public function create($userId, $title, $description, $content, $category, $imagePath = null) {
        try {
            $this->db->prepare("
                INSERT INTO articles (author_id, title, description, content, category, image_path, is_published)
                VALUES (:author_id, :title, :description, :content, :category, :image_path, FALSE)
            ");
            
            $result = $this->db->execute([
                ':author_id' => $userId,
                ':title' => $title,
                ':description' => $description,
                ':content' => $content,
                ':category' => $category,
                ':image_path' => $imagePath
            ]);

            return $result ? $this->db->lastInsertId() : false;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Actualizar artículo
     */
    public function update($id, $title, $description, $content, $category, $imagePath = null, $isPublished = false) {
        try {
            $fields = [
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'category' => $category,
                'is_published' => $isPublished ? 1 : 0
            ];

            if ($imagePath) {
                $fields['image_path'] = $imagePath;
            }

            $updates = [];
            $params = [':id' => $id];

            foreach ($fields as $field => $value) {
                $updates[] = "$field = :$field";
                $params[":$field"] = $value;
            }

            $this->db->prepare("UPDATE articles SET " . implode(', ', $updates) . " WHERE id = :id");
            return $this->db->execute($params);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Eliminar artículo
     */
    public function delete($id) {
        try {
            $this->db->prepare("DELETE FROM articles WHERE id = :id");
            return $this->db->execute([':id' => $id]);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Obtener artículos del usuario (incluyendo no publicados)
     */
    public function getUserArticles($userId) {
        $this->db->prepare("
            SELECT * FROM articles 
            WHERE author_id = :author_id
            ORDER BY created_at DESC
        ");
        $this->db->execute([':author_id' => $userId]);
        return $this->db->fetchAll();
    }

    /**
     * Publicar artículo
     */
    public function publish($id) {
        $this->db->prepare("UPDATE articles SET is_published = TRUE WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Despublicar artículo
     */
    public function unpublish($id) {
        $this->db->prepare("UPDATE articles SET is_published = FALSE WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Incrementar vistas
     */
    private function incrementViews($id) {
        $this->db->prepare("UPDATE articles SET views = views + 1 WHERE id = :id");
        $this->db->execute([':id' => $id]);
    }
}
