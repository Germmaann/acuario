<?php
/**
 * Modelo Fish
 * Maneja ficha de peces de la wiki
 */

class Fish {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /** Crear nueva ficha de pez */
    public function create($data) {
        $this->db->prepare(
            "INSERT INTO fish_wiki (
                common_name, scientific_name, family, origin,
                size_min, size_max, temperature_min, temperature_max,
                ph_min, ph_max, hardness_min, hardness_max,
                behavior, compatibility, difficulty, feeding,
                lifespan, description, main_image, status, author_id
            ) VALUES (
                :common_name, :scientific_name, :family, :origin,
                :size_min, :size_max, :temperature_min, :temperature_max,
                :ph_min, :ph_max, :hardness_min, :hardness_max,
                :behavior, :compatibility, :difficulty, :feeding,
                :lifespan, :description, :main_image, :status, :author_id
            )"
        );

        return $this->db->execute([
            ':common_name' => $data['common_name'],
            ':scientific_name' => $data['scientific_name'] ?? null,
            ':family' => $data['family'] ?? null,
            ':origin' => $data['origin'] ?? null,
            ':size_min' => $data['size_min'] ?? null,
            ':size_max' => $data['size_max'] ?? null,
            ':temperature_min' => $data['temperature_min'] ?? null,
            ':temperature_max' => $data['temperature_max'] ?? null,
            ':ph_min' => $data['ph_min'] ?? null,
            ':ph_max' => $data['ph_max'] ?? null,
            ':hardness_min' => $data['hardness_min'] ?? null,
            ':hardness_max' => $data['hardness_max'] ?? null,
            ':behavior' => $data['behavior'] ?? null,
            ':compatibility' => $data['compatibility'] ?? null,
            ':difficulty' => $data['difficulty'] ?? DIFFICULTY_MEDIUM,
            ':feeding' => $data['feeding'] ?? null,
            ':lifespan' => $data['lifespan'] ?? null,
            ':description' => $data['description'] ?? null,
            ':main_image' => $data['main_image'] ?? null,
            ':status' => $data['status'] ?? FISH_STATUS_PENDING,
            ':author_id' => $data['author_id']
        ]) ? $this->db->lastInsertId() : false;
    }

    /** Actualizar ficha de pez */
    public function update($id, $data) {
        $fields = [];
        $params = [':id' => $id];

        $allowedFields = [
            'common_name', 'scientific_name', 'family', 'origin',
            'size_min', 'size_max', 'temperature_min', 'temperature_max',
            'ph_min', 'ph_max', 'hardness_min', 'hardness_max',
            'behavior', 'compatibility', 'difficulty', 'feeding',
            'lifespan', 'description', 'main_image', 'status'
        ];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = :$field";
                $params[':' . $field] = $data[$field];
            }
        }

        if (empty($fields)) {
            return true;
        }

        $this->db->prepare(
            "UPDATE fish_wiki SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id"
        );
        return $this->db->execute($params);
    }

    /** Obtener pez por ID */
    public function getById($id) {
        $this->db->prepare(
            "SELECT f.*, u.username as author_name, u.full_name as author_fullname
             FROM fish_wiki f
             JOIN users u ON f.author_id = u.id
             WHERE f.id = :id"
        );
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }

    /** Obtener peces aprobados con búsqueda/paginación */
    public function getApproved($search = '', $difficulty = '', $page = 1, $limit = 12) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT f.*, u.username as author_name, u.full_name as author_fullname
                  FROM fish_wiki f
                  JOIN users u ON f.author_id = u.id
                  WHERE f.status = :status";

        $params = [':status' => FISH_STATUS_APPROVED];

        if (!empty($search)) {
            $query .= " AND (f.common_name LIKE :search OR f.scientific_name LIKE :search)";
            $params[':search'] = "%$search%";
        }

        if (!empty($difficulty)) {
            $query .= " AND f.difficulty = :difficulty";
            $params[':difficulty'] = $difficulty;
        }

        $query .= " ORDER BY f.created_at DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = (int)$limit;
        $params[':offset'] = (int)$offset;

        $this->db->prepare($query);
        $this->db->execute($params);
        return $this->db->fetchAll();
    }

    /** Contar peces aprobados */
    public function countApproved($search = '', $difficulty = '') {
        $query = "SELECT COUNT(*) as total FROM fish_wiki WHERE status = :status";
        $params = [':status' => FISH_STATUS_APPROVED];

        if (!empty($search)) {
            $query .= " AND (common_name LIKE :search OR scientific_name LIKE :search)";
            $params[':search'] = "%$search%";
        }

        if (!empty($difficulty)) {
            $query .= " AND difficulty = :difficulty";
            $params[':difficulty'] = $difficulty;
        }

        $this->db->prepare($query);
        $this->db->execute($params);
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /** Obtener peces pendientes de aprobación (admin) */
    public function getPending($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $this->db->prepare(
            "SELECT f.*, u.username as author_name, u.full_name as author_fullname
             FROM fish_wiki f
             JOIN users u ON f.author_id = u.id
             WHERE f.status = :status
             ORDER BY f.created_at ASC
             LIMIT :limit OFFSET :offset"
        );
        return $this->db->execute([
            ':status' => FISH_STATUS_PENDING,
            ':limit' => (int)$limit,
            ':offset' => (int)$offset
        ]) ? $this->db->fetchAll() : [];
    }
    
    /** Obtener peces rechazados (admin) */
    public function getRejected($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $this->db->prepare(
            "SELECT f.*, u.username as author_name, u.full_name as author_fullname
             FROM fish_wiki f
             JOIN users u ON f.author_id = u.id
             WHERE f.status = :status
             ORDER BY f.updated_at DESC
             LIMIT :limit OFFSET :offset"
        );
        return $this->db->execute([
            ':status' => FISH_STATUS_REJECTED,
            ':limit' => (int)$limit,
            ':offset' => (int)$offset
        ]) ? $this->db->fetchAll() : [];
    }
    
    /** Obtener todos los peces (admin) */
    public function getAll($page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        $this->db->prepare(
            "SELECT f.*, u.username as author_name, u.full_name as author_fullname
             FROM fish_wiki f
             JOIN users u ON f.author_id = u.id
             ORDER BY f.created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        return $this->db->execute([
            ':limit' => (int)$limit,
            ':offset' => (int)$offset
        ]) ? $this->db->fetchAll() : [];
    }
    
    /** Contar peces por estado */
    public function countByStatus($status = '') {
        if (empty($status)) {
            $query = "SELECT COUNT(*) as total FROM fish_wiki";
            $params = [];
        } else {
            $query = "SELECT COUNT(*) as total FROM fish_wiki WHERE status = :status";
            $params = [':status' => $status];
        }
        
        $this->db->prepare($query);
        $this->db->execute($params);
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /** Eliminar pez */
    public function delete($id) {
        $this->db->prepare("DELETE FROM fish_wiki WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }

    /** Obtener imágenes del pez */
    public function getImages($fishId) {
        $this->db->prepare(
            "SELECT * FROM fish_images WHERE fish_id = :fish_id ORDER BY created_at DESC"
        );
        $this->db->execute([':fish_id' => $fishId]);
        return $this->db->fetchAll();
    }

    /** Agregar imagen a pez */
    public function addImage($fishId, $imagePath, $title, $description, $uploadedBy) {
        $this->db->prepare(
            "INSERT INTO fish_images (fish_id, image_path, title, description, uploaded_by)
             VALUES (:fish_id, :image_path, :title, :description, :uploaded_by)"
        );

        return $this->db->execute([
            ':fish_id' => $fishId,
            ':image_path' => $imagePath,
            ':title' => $title,
            ':description' => $description,
            ':uploaded_by' => $uploadedBy
        ]) ? $this->db->lastInsertId() : false;
    }

    /** Eliminar imagen */
    public function deleteImage($imageId) {
        $this->db->prepare("DELETE FROM fish_images WHERE id = :id");
        return $this->db->execute([':id' => $imageId]);
    }

    /** Registrar edición en historial */
    public function logEdit($fishId, $editedBy, $changes, $reason = '') {
        $this->db->prepare(
            "INSERT INTO fish_edit_history (fish_id, edited_by, changes_json, reason)
             VALUES (:fish_id, :edited_by, :changes_json, :reason)"
        );

        return $this->db->execute([
            ':fish_id' => $fishId,
            ':edited_by' => $editedBy,
            ':changes_json' => json_encode($changes),
            ':reason' => $reason
        ]);
    }

    /** Obtener historial de ediciones */
    public function getEditHistory($fishId) {
        $this->db->prepare(
            "SELECT eh.*, u.username
             FROM fish_edit_history eh
             JOIN users u ON eh.edited_by = u.id
             WHERE eh.fish_id = :fish_id
             ORDER BY eh.created_at DESC"
        );
        $this->db->execute([':fish_id' => $fishId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener últimos peces publicados
     */
    public function getLatest($limit = 6) {
        $this->db->prepare("
            SELECT id, common_name as name, scientific_name, main_image as image_path, 
                   difficulty, temperature_min, temperature_max, 
                   size_min, size_max, created_at
            FROM fish_wiki
            WHERE status = 'aprobado'
            ORDER BY created_at DESC
            LIMIT :limit
        ");
        $this->db->execute([':limit' => $limit]);
        return $this->db->fetchAll();
    }
}
