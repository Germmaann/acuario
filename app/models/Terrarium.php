<?php
/**
 * Modelo Terrarium
 * Maneja terrarios del usuario
 */

class Terrarium {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crear nuevo terrario
     */
    public function create($data) {
        $this->db->prepare(
            "INSERT INTO terrariums (
                user_id, name, description, volume_liters, type,
                dimensions_length, dimensions_width, dimensions_height,
                lighting_hours, heating_type, humidity_level,
                temperature_min, temperature_max, main_image, status
            ) VALUES (
                :user_id, :name, :description, :volume_liters, :type,
                :dimensions_length, :dimensions_width, :dimensions_height,
                :lighting_hours, :heating_type, :humidity_level,
                :temperature_min, :temperature_max, :main_image, :status
            )"
        );

        return $this->db->execute([
            ':user_id' => $data['user_id'],
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':volume_liters' => $data['volume_liters'] ?? null,
            ':type' => $data['type'] ?? 'tropical',
            ':dimensions_length' => $data['dimensions_length'] ?? null,
            ':dimensions_width' => $data['dimensions_width'] ?? null,
            ':dimensions_height' => $data['dimensions_height'] ?? null,
            ':lighting_hours' => $data['lighting_hours'] ?? null,
            ':heating_type' => $data['heating_type'] ?? null,
            ':humidity_level' => $data['humidity_level'] ?? null,
            ':temperature_min' => $data['temperature_min'] ?? null,
            ':temperature_max' => $data['temperature_max'] ?? null,
            ':main_image' => $data['main_image'] ?? null,
            ':status' => $data['status'] ?? 'activo'
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener terrario por ID
     */
    public function getById($id) {
        $this->db->prepare("SELECT * FROM terrariums WHERE id = :id");
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }

    /**
     * Obtener terrarios del usuario
     */
    public function getByUser($userId, $status = '') {
        $query = "SELECT * FROM terrariums WHERE user_id = :user_id";
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
     * Actualizar terrario
     */
    public function update($id, $data) {
        $fields = [];
        $params = [':id' => $id];

        $allowedFields = [
            'name', 'description', 'volume_liters', 'type',
            'dimensions_length', 'dimensions_width', 'dimensions_height',
            'lighting_hours', 'heating_type', 'humidity_level',
            'temperature_min', 'temperature_max', 'main_image', 'status'
        ];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = :$field";
                $params[':' . $field] = $data[$field];
            }
        }

        if (empty($fields)) {
            return true;
        }

        $this->db->prepare("UPDATE terrariums SET " . implode(', ', $fields) . " WHERE id = :id");
        return $this->db->execute($params);
    }

    /**
     * Eliminar terrario
     */
    public function delete($id) {
        $this->db->prepare("DELETE FROM terrariums WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Obtener habitantes del terrario
     */
    public function getInhabitants($terrariumId) {
        $this->db->prepare("SELECT * FROM terrarium_inhabitants WHERE terrarium_id = :terrarium_id ORDER BY added_date DESC");
        $this->db->execute([':terrarium_id' => $terrariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Agregar habitante
     */
    public function addInhabitant($terrariumId, $data) {
        $this->db->prepare(
            "INSERT INTO terrarium_inhabitants (terrarium_id, name, type, quantity, notes, added_date)
             VALUES (:terrarium_id, :name, :type, :quantity, :notes, NOW())"
        );

        return $this->db->execute([
            ':terrarium_id' => $terrariumId,
            ':name' => $data['name'],
            ':type' => $data['type'] ?? null,
            ':quantity' => $data['quantity'] ?? 1,
            ':notes' => $data['notes'] ?? null
        ]);
    }

    /**
     * Obtener galería del terrario
     */
    public function getGallery($terrariumId) {
        $this->db->prepare("SELECT * FROM terrarium_gallery WHERE terrarium_id = :terrarium_id ORDER BY created_at DESC");
        $this->db->execute([':terrarium_id' => $terrariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener registros de mantenimiento
     */
    public function getMaintenanceLogs($terrariumId) {
        $this->db->prepare("SELECT * FROM terrarium_maintenance WHERE terrarium_id = :terrarium_id ORDER BY created_at DESC");
        $this->db->execute([':terrarium_id' => $terrariumId]);
        return $this->db->fetchAll();
    }

    /**
     * Agregar registro de mantenimiento
     */
    public function addMaintenanceLog($terrariumId, $data) {
        $this->db->prepare(
            "INSERT INTO terrarium_maintenance (terrarium_id, log_type, description, reminder_enabled, reminder_days, created_at)
             VALUES (:terrarium_id, :log_type, :description, :reminder_enabled, :reminder_days, NOW())"
        );

        return $this->db->execute([
            ':terrarium_id' => $terrariumId,
            ':log_type' => $data['log_type'] ?? null,
            ':description' => $data['description'] ?? null,
            ':reminder_enabled' => isset($data['reminder_enabled']) ? 1 : 0,
            ':reminder_days' => $data['reminder_days'] ?? null
        ]);
    }

    /**
     * Obtener estadísticas del usuario
     */
    public function getStatistics($userId) {
        $this->db->prepare("SELECT 
            COUNT(*) as total_terrariums,
            SUM(CASE WHEN status = 'activo' THEN 1 ELSE 0 END) as active_terrariums,
            SUM(CASE WHEN status = 'inactivo' THEN 1 ELSE 0 END) as inactive_terrariums,
            SUM(volume_liters) as total_capacity,
            AVG(temperature_min) as avg_temp_min,
            AVG(temperature_max) as avg_temp_max,
            AVG(humidity_level) as avg_humidity
        FROM terrariums WHERE user_id = :user_id");
        $this->db->execute([':user_id' => $userId]);
        return $this->db->fetch();
    }

    /**
     * Buscar terrarios por nombre
     */
    public function search($userId, $searchTerm, $type = '', $status = '') {
        $query = "SELECT * FROM terrariums WHERE user_id = :user_id AND name LIKE :search";
        $params = [
            ':user_id' => $userId,
            ':search' => "%$searchTerm%"
        ];

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
     * Obtener todas las galerías públicas
     */
    public function getAllGalleries($limit = 20, $offset = 0) {
        $this->db->prepare("SELECT tg.*, t.name as terrarium_name, u.username, u.id as user_id
        FROM terrarium_gallery tg
        INNER JOIN terrariums t ON tg.terrarium_id = t.id
        INNER JOIN users u ON tg.uploaded_by = u.id
        ORDER BY tg.created_at DESC
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
        $this->db->prepare("SELECT tm.*, t.name as terrarium_name
        FROM terrarium_maintenance tm
        INNER JOIN terrariums t ON tm.terrarium_id = t.id
        WHERE t.user_id = :user_id
        ORDER BY tm.created_at DESC
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
    public function getAllMaintenance($userId) {
        $this->db->prepare("SELECT tm.*, t.name as terrarium_name, t.id as terrarium_id
        FROM terrarium_maintenance tm
        INNER JOIN terrariums t ON tm.terrarium_id = t.id
        WHERE t.user_id = :user_id
        ORDER BY tm.created_at DESC");
        $this->db->execute([':user_id' => $userId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener alertas de mantenimiento vencido
     */
    public function getMaintenanceAlerts($userId) {
        $this->db->prepare("SELECT tm.*, t.name as terrarium_name, t.id as terrarium_id,
        DATEDIFF(DATE_ADD(tm.created_at, INTERVAL tm.reminder_days DAY), NOW()) as days_remaining
        FROM terrarium_maintenance tm
        INNER JOIN terrariums t ON tm.terrarium_id = t.id
        WHERE t.user_id = :user_id 
        AND tm.reminder_enabled = 1
        AND DATEDIFF(DATE_ADD(tm.created_at, INTERVAL tm.reminder_days DAY), NOW()) <= 7
        AND DATEDIFF(DATE_ADD(tm.created_at, INTERVAL tm.reminder_days DAY), NOW()) >= -30
        ORDER BY DATEDIFF(DATE_ADD(tm.created_at, INTERVAL tm.reminder_days DAY), NOW()) ASC");
        $this->db->execute([':user_id' => $userId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener alertas de temperatura
     */
    public function getTemperatureAlerts($userId) {
        // Esta función es para uso futuro con sensores IoT
        return [];
    }

    /**
     * Obtener últimos terrarios públicos con fotos de galería
     */
    public function getLatestPublic($limit = 6) {
        $this->db->prepare("
            SELECT t.id, t.name, t.description, t.volume_liters, t.type, 
                   t.created_at, u.username, u.id as user_id,
                   GROUP_CONCAT(tg.image_path) as gallery_photos
            FROM terrariums t
            JOIN users u ON t.user_id = u.id
            LEFT JOIN terrarium_gallery tg ON t.id = tg.terrarium_id
            WHERE t.status = 'activo'
            GROUP BY t.id
            ORDER BY t.created_at DESC
            LIMIT :limit
        ");
        $this->db->execute([':limit' => $limit]);
        $results = $this->db->fetchAll();
        
        // Convertir gallery_photos a array
        foreach ($results as &$terrarium) {
            if ($terrarium['gallery_photos']) {
                $terrarium['gallery_photos'] = explode(',', $terrarium['gallery_photos']);
            } else {
                $terrarium['gallery_photos'] = [];
            }
        }
        
        return $results;
    }

    /**
     * Obtener terrarios públicos con paginación
     */
    public function getPublic($page = 1, $perPage = 12) {
        $offset = ($page - 1) * $perPage;
        $this->db->prepare("
            SELECT t.id, t.name, t.description, t.volume_liters, t.type, 
                   t.created_at, u.username, u.id as user_id,
                   GROUP_CONCAT(tg.image_path) as gallery_photos
            FROM terrariums t
            JOIN users u ON t.user_id = u.id
            LEFT JOIN terrarium_gallery tg ON t.id = tg.terrarium_id
            WHERE t.status = 'activo'
            GROUP BY t.id
            ORDER BY t.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $this->db->execute([':limit' => $perPage, ':offset' => $offset]);
        $results = $this->db->fetchAll();
        
        // Convertir gallery_photos a array
        foreach ($results as &$terrarium) {
            if ($terrarium['gallery_photos']) {
                $terrarium['gallery_photos'] = explode(',', $terrarium['gallery_photos']);
            } else {
                $terrarium['gallery_photos'] = [];
            }
        }
        
        return $results;
    }

    /**
     * Contar terrarios públicos
     */
    public function countPublic() {
        $this->db->prepare("
            SELECT COUNT(*) as total
            FROM terrariums
            WHERE status = 'activo'
        ");
        $this->db->execute();
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }}