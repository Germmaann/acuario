<?php
/**
 * Modelo Report
 * Maneja reportes de errores en fichas de peces
 */

class Report {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crear nuevo reporte
     */
    public function create($data) {
        $this->db->prepare(
            "INSERT INTO fish_reports (fish_id, reporter_id, report_type, comment)
             VALUES (:fish_id, :reporter_id, :report_type, :comment)"
        );

        return $this->db->execute([
            ':fish_id' => $data['fish_id'],
            ':reporter_id' => $data['reporter_id'],
            ':report_type' => $data['report_type'],
            ':comment' => $data['comment']
        ]) ? $this->db->lastInsertId() : false;
    }

    /**
     * Obtener reporte por ID
     */
    public function getById($id) {
        $this->db->prepare(
            "SELECT r.*, u.username as reporter_name, f.common_name as fish_name,
                    admin.username as resolved_by_name
             FROM fish_reports r
             JOIN users u ON r.reporter_id = u.id
             JOIN fish_wiki f ON r.fish_id = f.id
             LEFT JOIN users admin ON r.resolved_by = admin.id
             WHERE r.id = :id"
        );
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }

    /**
     * Obtener reportes de un pez
     */
    public function getByFish($fishId) {
        $this->db->prepare(
            "SELECT r.*, u.username as reporter_name
             FROM fish_reports r
             JOIN users u ON r.reporter_id = u.id
             WHERE r.fish_id = :fish_id
             ORDER BY r.created_at DESC"
        );
        $this->db->execute([':fish_id' => $fishId]);
        return $this->db->fetchAll();
    }

    /**
     * Obtener todos los reportes (Admin)
     */
    public function getAll($status = '', $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT r.*, u.username as reporter_name, f.common_name as fish_name
                  FROM fish_reports r
                  JOIN users u ON r.reporter_id = u.id
                  JOIN fish_wiki f ON r.fish_id = f.id
                  WHERE 1=1";
        
        $params = [];

        if (!empty($status)) {
            $query .= " AND r.status = :status";
            $params[':status'] = $status;
        }

        $query .= " ORDER BY r.created_at DESC LIMIT :limit OFFSET :offset";
        
        $this->db->prepare($query);
        $this->db->execute(array_merge($params, [
            ':limit' => (int)$limit,
            ':offset' => (int)$offset
        ]));
        return $this->db->fetchAll();
    }

    /**
     * Contar reportes
     */
    public function count($status = '') {
        $query = "SELECT COUNT(*) as total FROM fish_reports WHERE 1=1";
        $params = [];

        if (!empty($status)) {
            $query .= " AND status = :status";
            $params[':status'] = $status;
        }

        $this->db->prepare($query);
        $this->db->execute($params);
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Actualizar estado del reporte
     */
    public function updateStatus($id, $status, $adminId = null, $response = '') {
        $this->db->prepare(
            "UPDATE fish_reports 
             SET status = :status, 
                 resolved_by = :resolved_by, 
                 admin_response = :response,
                 updated_at = NOW()
             WHERE id = :id"
        );

        return $this->db->execute([
            ':status' => $status,
            ':resolved_by' => $adminId,
            ':response' => $response,
            ':id' => $id
        ]);
    }

    /**
     * Verificar si usuario ya reportó este pez
     */
    public function hasUserReported($fishId, $userId) {
        $this->db->prepare(
            "SELECT id FROM fish_reports 
             WHERE fish_id = :fish_id AND reporter_id = :reporter_id 
             AND status != :status"
        );
        $this->db->execute([
            ':fish_id' => $fishId,
            ':reporter_id' => $userId,
            ':status' => REPORT_STATUS_RESOLVED
        ]);
        return $this->db->fetch() !== false;
    }

    /**
     * Obtener estadísticas de reportes
     */
    public function getStatistics() {
        $this->db->prepare(
            "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'nuevo' THEN 1 ELSE 0 END) as new,
                SUM(CASE WHEN status = 'en_revisión' THEN 1 ELSE 0 END) as reviewing,
                SUM(CASE WHEN status = 'resuelto' THEN 1 ELSE 0 END) as resolved
             FROM fish_reports"
        );
        $this->db->execute();
        return $this->db->fetch();
    }

    /**
     * Eliminar reporte
     */
    public function delete($id) {
        $this->db->prepare("DELETE FROM fish_reports WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }
}
