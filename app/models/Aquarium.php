<?php
/**
 * Modelo Aquarium
 * Maneja acuarios del usuario
 */

class Aquarium {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crear nuevo acuario
     */
    public function create($data) {
        $this->db->prepare(
            "INSERT INTO aquariums (
                user_id, name, description, volume_liters, type,
                dimensions_length, dimensions_width, dimensions_height,
                filter_type, lighting_hours, co2_injection, main_image, status
            ) VALUES (
                :user_id, :name, :description, :volume_liters, :type,
                :dimensions_length, :dimensions_width, :dimensions_height,
                :filter_type, :lighting_hours, :co2_injection, :main_image, :status
            )"
        );

        return $this->db->execute([
            ':user_id' => $data['user_id'],
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':volume_liters' => $data['volume_liters'] ?? null,
            ':type' => $data['type'] ?? 'agua_dulce',
            ':dimensions_length' => $data['dimensions_length'] ?? null,
            ':dimensions_width' => $data['dimensions_width'] ?? null,
            ':dimensions_height' => $data['dimensions_height'] ?? null,
            ':filter_type' => $data['filter_type'] ?? null,
            ':lighting_hours' => $data['lighting_hours'] ?? null,
            ':co2_injection' => isset($data['co2_injection']) ? 1 : 0,
            ':main_image' => $data['main_image'] ?? null,
            ':status' => $data['status'] ?? 'activo'
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener acuario por ID
     */
    public function getById($id) {
        $this->db->prepare("SELECT * FROM aquariums WHERE id = :id");
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }

    /**
     * Obtener acuarios del usuario
     */
    public function getByUser($userId, $status = '') {
        $query = "SELECT * FROM aquariums WHERE user_id = :user_id";
        $params = [':user_id' => $userId];

        if (!empty($status)) {
            $query .= " AND status = :status";
            $params[':status'] = $status;
        }

        $query .= " ORDER BY created_at DESC";
        
        $this->db->prepare($query);
        $this->db->execute($params);
        return $this->db->fetchAll();
    }

    /**
     * Actualizar acuario
     */
    public function update($id, $data) {
        $fields = [];
        $params = [':id' => $id];

        $allowedFields = [
            'name', 'description', 'volume_liters', 'type',
            'dimensions_length', 'dimensions_width', 'dimensions_height',
            'filter_type', 'lighting_hours', 'co2_injection', 'main_image', 'status'
        ];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = :$field";
                if ($field === 'co2_injection') {
                    $params[':' . $field] = isset($data[$field]) ? 1 : 0;
                } else {
                    $params[':' . $field] = $data[$field];
                }
            }
        }

        if (empty($fields)) {
            return true;
        }

        $this->db->prepare(
            "UPDATE aquariums SET " . implode(', ', $fields) . " WHERE id = :id"
        );
        return $this->db->execute($params);
    }

    /**
     * Eliminar acuario
     */
    public function delete($id) {
        $this->db->prepare("DELETE FROM aquariums WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Agregar pez al acuario
     */
    public function addFish($aquariumId, $fishId, $quantity = 1, $notes = '') {
        $this->db->prepare(
            "INSERT INTO aquarium_fish (aquarium_id, fish_id, quantity, notes, added_date)
             VALUES (:aquarium_id, :fish_id, :quantity, :notes, NOW())"
        );

        return $this->db->execute([
            ':aquarium_id' => $aquariumId,
            ':fish_id' => $fishId,
            ':quantity' => $quantity,
            ':notes' => $notes
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener peces del acuario
     */
    public function getFishes($aquariumId) {
        $this->db->prepare(
            "SELECT af.*, f.common_name, f.scientific_name, f.main_image, f.compatibility, f.author_id, f.description
             FROM aquarium_fish af
             JOIN fish_wiki f ON af.fish_id = f.id
             WHERE af.aquarium_id = :aquarium_id
             ORDER BY af.added_date DESC"
        );
        $this->db->execute([':aquarium_id' => $aquariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Remover pez del acuario
     */
    public function removeFish($aquariumFishId) {
        $this->db->prepare("DELETE FROM aquarium_fish WHERE id = :id");
        return $this->db->execute([':id' => $aquariumFishId]);
    }

    /**
     * Agregar planta al acuario
     */
    public function addPlant($aquariumId, $data) {
        $this->db->prepare(
            "INSERT INTO aquarium_plants (aquarium_id, name, quantity, care_level, lighting_requirement, added_date, notes)
             VALUES (:aquarium_id, :name, :quantity, :care_level, :lighting_requirement, NOW(), :notes)"
        );

        return $this->db->execute([
            ':aquarium_id' => $aquariumId,
            ':name' => $data['name'],
            ':quantity' => $data['quantity'] ?? 1,
            ':care_level' => $data['care_level'] ?? 'medio',
            ':lighting_requirement' => $data['lighting_requirement'] ?? null,
            ':notes' => $data['notes'] ?? null
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener plantas del acuario
     */
    public function getPlants($aquariumId) {
        $this->db->prepare(
            "SELECT * FROM aquarium_plants WHERE aquarium_id = :aquarium_id ORDER BY added_date DESC"
        );
        $this->db->execute([':aquarium_id' => $aquariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Eliminar planta
     */
    public function deletePlant($plantId) {
        $this->db->prepare("DELETE FROM aquarium_plants WHERE id = :id");
        return $this->db->execute([':id' => $plantId]);
    }

    /**
     * Agregar sustrato
     */
    public function addSubstrate($aquariumId, $data) {
        $this->db->prepare(
            "INSERT INTO aquarium_substrates (aquarium_id, name, type, quantity_kg, color, notes, added_date)
             VALUES (:aquarium_id, :name, :type, :quantity_kg, :color, :notes, NOW())"
        );

        return $this->db->execute([
            ':aquarium_id' => $aquariumId,
            ':name' => $data['name'],
            ':type' => $data['type'] ?? null,
            ':quantity_kg' => $data['quantity_kg'] ?? null,
            ':color' => $data['color'] ?? null,
            ':notes' => $data['notes'] ?? null
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener sustratos del acuario
     */
    public function getSubstrates($aquariumId) {
        $this->db->prepare(
            "SELECT * FROM aquarium_substrates WHERE aquarium_id = :aquarium_id ORDER BY added_date DESC"
        );
        $this->db->execute([':aquarium_id' => $aquariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Eliminar sustrato
     */
    public function deleteSubstrate($substrateId) {
        $this->db->prepare("DELETE FROM aquarium_substrates WHERE id = :id");
        return $this->db->execute([':id' => $substrateId]);
    }

    /**
     * Agregar entrada en bitácora de mantenimiento
     */
    public function addMaintenanceLog($aquariumId, $data) {
        $this->db->prepare(
            "INSERT INTO maintenance_logs (aquarium_id, log_type, description, percentage, notes, reminder_enabled, reminder_days, reminder_next_at)
             VALUES (:aquarium_id, :log_type, :description, :percentage, :notes, :reminder_enabled, :reminder_days, :reminder_next_at)"
        );

        return $this->db->execute([
            ':aquarium_id' => $aquariumId,
            ':log_type' => $data['log_type'],
            ':description' => $data['description'] ?? null,
            ':percentage' => $data['percentage'] ?? null,
            ':notes' => $data['notes'] ?? null,
            ':reminder_enabled' => !empty($data['reminder_enabled']) ? 1 : 0,
            ':reminder_days' => $data['reminder_days'] ?? null,
            ':reminder_next_at' => $data['reminder_next_at'] ?? null
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener bitácora de mantenimiento
     */
    public function getMaintenanceLogs($aquariumId, $limit = 50) {
        $this->db->prepare(
            "SELECT * FROM maintenance_logs WHERE aquarium_id = :aquarium_id 
             ORDER BY created_at DESC LIMIT :limit"
        );
        $this->db->execute([
            ':aquarium_id' => $aquariumId,
            ':limit' => (int)$limit
        ]);
        return $this->db->fetchAll();
    }

    /**
     * Agregar imagen a galería
     */
    public function addGalleryImage($aquariumId, $imagePath, $title, $description) {
        $this->db->prepare(
            "INSERT INTO aquarium_gallery (aquarium_id, image_path, title, description, uploaded_by)
             VALUES (:aquarium_id, :image_path, :title, :description, :uploaded_by)"
        );

        return $this->db->execute([
            ':aquarium_id' => $aquariumId,
            ':image_path' => $imagePath,
            ':title' => $title,
            ':description' => $description,
            ':uploaded_by' => Session::getUserId()
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener galería del acuario
     */
    public function getGallery($aquariumId) {
        $this->db->prepare(
            "SELECT * FROM aquarium_gallery WHERE aquarium_id = :aquarium_id 
             ORDER BY created_at DESC"
        );
        $this->db->execute([':aquarium_id' => $aquariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Eliminar imagen de galería
     */
    public function deleteGalleryImage($imageId) {
        $this->db->prepare("DELETE FROM aquarium_gallery WHERE id = :id");
        return $this->db->execute([':id' => $imageId]);
    }

    /**
     * Obtener estadísticas del usuario
     */
    public function getStatistics($userId) {
        $this->db->prepare("SELECT 
            COUNT(*) as total_aquariums,
            SUM(CASE WHEN status = 'activo' THEN 1 ELSE 0 END) as active_aquariums,
            SUM(CASE WHEN status = 'inactivo' THEN 1 ELSE 0 END) as inactive_aquariums,
            SUM(volume_liters) as total_capacity,
            AVG(lighting_hours) as avg_lighting_hours,
            SUM(CASE WHEN co2_injection = 1 THEN 1 ELSE 0 END) as co2_count
        FROM aquariums WHERE user_id = :user_id");
        $this->db->execute([':user_id' => $userId]);
        return $this->db->fetch();
    }

    /**
     * Buscar acuarios por nombre con filtros
     */
    public function search($userId, $searchTerm, $type = '', $status = '') {
        $query = "SELECT * FROM aquariums WHERE user_id = :user_id";
        $params = [
            ':user_id' => $userId
        ];

        if (!empty($searchTerm)) {
            $query .= " AND name LIKE :search";
            $params[':search'] = "%$searchTerm%";
        }

        if (!empty($type)) {
            $query .= " AND type = :type";
            $params[':type'] = $type;
        }

        if (!empty($status)) {
            $query .= " AND status = :status";
            $params[':status'] = $status;
        }

        $query .= " ORDER BY created_at DESC";
        
        $this->db->prepare($query);
        $this->db->execute($params);
        return $this->db->fetchAll();
    }

    /**
     * Obtener todas las galerías públicas de acuarios
     */
    public function getAllGalleries($limit = 20, $offset = 0) {
        $this->db->prepare("SELECT 
            ag.*, 
            a.id as aquarium_id,
            a.name as aquarium_name,
            a.type as aquarium_type,
            a.volume_liters,
            a.dimensions_length,
            a.dimensions_width,
            a.dimensions_height,
            u.username, 
            u.id as user_id
        FROM aquarium_gallery ag
        INNER JOIN aquariums a ON ag.aquarium_id = a.id
        INNER JOIN users u ON a.user_id = u.id
        ORDER BY ag.created_at DESC
        LIMIT :limit OFFSET :offset");
        $this->db->execute([
            ':limit' => $limit,
            ':offset' => $offset
        ]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener últimos mantenimientos del usuario
     */
    public function getRecentMaintenance($userId, $limit = 10) {
        $this->db->prepare("SELECT ml.*, a.name as aquarium_name
        FROM maintenance_logs ml
        INNER JOIN aquariums a ON ml.aquarium_id = a.id
        WHERE a.user_id = :user_id
        ORDER BY ml.created_at DESC
        LIMIT :limit");
        $this->db->execute([
            ':user_id' => $userId,
            ':limit' => $limit
        ]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener todos los mantenimientos del usuario (para exportar)
     */
    public function getAllMaintenanceByUser($userId) {
        $this->db->prepare("SELECT ml.*, a.name as aquarium_name, a.id as aquarium_id
        FROM maintenance_logs ml
        INNER JOIN aquariums a ON ml.aquarium_id = a.id
        WHERE a.user_id = :user_id
        ORDER BY ml.created_at DESC");
        $this->db->execute([':user_id' => $userId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener alertas de mantenimiento próximas o vencidas
     */
    public function getMaintenanceAlerts($userId) {
        $this->db->prepare("SELECT ml.*, a.name as aquarium_name, a.id as aquarium_id,
        TIMESTAMPDIFF(DAY, NOW(), ml.reminder_next_at) as days_remaining
        FROM maintenance_logs ml
        INNER JOIN aquariums a ON ml.aquarium_id = a.id
        WHERE a.user_id = :user_id 
        AND ml.reminder_enabled = 1
        AND ml.reminder_next_at IS NOT NULL
        AND TIMESTAMPDIFF(DAY, NOW(), ml.reminder_next_at) <= 7
        AND TIMESTAMPDIFF(DAY, NOW(), ml.reminder_next_at) >= -30
        ORDER BY TIMESTAMPDIFF(DAY, NOW(), ml.reminder_next_at) ASC");
        $this->db->execute([':user_id' => $userId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener últimos acuarios públicos con fotos de galería
     */
    public function getLatestPublic($limit = 6) {
        $this->db->prepare("
            SELECT a.id, a.name, a.description, a.volume_liters, a.type, 
                   a.created_at, u.username, u.id as user_id,
                   GROUP_CONCAT(ag.image_path) as gallery_photos
            FROM aquariums a
            JOIN users u ON a.user_id = u.id
            LEFT JOIN aquarium_gallery ag ON a.id = ag.aquarium_id
            WHERE a.status = 'activo'
            GROUP BY a.id
            ORDER BY a.created_at DESC
            LIMIT :limit
        ");
        $this->db->execute([':limit' => $limit]);
        $results = $this->db->fetchAll();
        
        // Convertir gallery_photos a array
        foreach ($results as &$aquarium) {
            if ($aquarium['gallery_photos']) {
                $aquarium['gallery_photos'] = explode(',', $aquarium['gallery_photos']);
            } else {
                $aquarium['gallery_photos'] = [];
            }
        }
        
        return $results;
    }

    /**
     * Obtener acuarios públicos con paginación
     */
    public function getPublic($page = 1, $perPage = 12) {
        $offset = ($page - 1) * $perPage;
        $this->db->prepare("
            SELECT a.id, a.name, a.description, a.volume_liters, a.type, 
                   a.created_at, u.username, u.id as user_id,
                   GROUP_CONCAT(ag.image_path) as gallery_photos
            FROM aquariums a
            JOIN users u ON a.user_id = u.id
            LEFT JOIN aquarium_gallery ag ON a.id = ag.aquarium_id
            WHERE a.status = 'activo'
            GROUP BY a.id
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $this->db->execute([':limit' => $perPage, ':offset' => $offset]);
        $results = $this->db->fetchAll();
        
        // Convertir gallery_photos a array
        foreach ($results as &$aquarium) {
            if ($aquarium['gallery_photos']) {
                $aquarium['gallery_photos'] = explode(',', $aquarium['gallery_photos']);
            } else {
                $aquarium['gallery_photos'] = [];
            }
        }
        
        return $results;
    }

    /**
     * Contar acuarios públicos
     */
    public function countPublic() {
        $this->db->prepare("
            SELECT COUNT(*) as total
            FROM aquariums
            WHERE status = 'activo'
        ");
        $this->db->execute();
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }}