<?php
/**
 * Modelo User
 * Maneja usuarios del sistema
 */

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Crear nuevo usuario
     */
    public function create($data) {
        $this->db->prepare(
            "INSERT INTO users (username, email, password_hash, full_name, role_id) 
             VALUES (:username, :email, :password_hash, :full_name, :role_id)"
        );

        $this->db->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password_hash' => Security::hashPassword($data['password']),
            ':full_name' => $data['full_name'] ?? '',
            ':role_id' => $data['role_id'] ?? 2 // Usuario por defecto
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Obtener usuario por ID
     */
    public function getById($id) {
        $this->db->prepare(
            "SELECT u.*, r.name as role_name 
             FROM users u
             JOIN roles r ON u.role_id = r.id
             WHERE u.id = :id"
        );
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }

    /**
     * Obtener usuario por email
     */
    public function getByEmail($email) {
        $this->db->prepare(
            "SELECT u.*, r.name as role_name 
             FROM users u
             JOIN roles r ON u.role_id = r.id
             WHERE u.email = :email"
        );
        $this->db->execute([':email' => $email]);
        return $this->db->fetch();
    }

    /**
     * Obtener usuario por username
     */
    public function getByUsername($username) {
        $this->db->prepare(
            "SELECT u.*, r.name as role_name 
             FROM users u
             JOIN roles r ON u.role_id = r.id
             WHERE u.username = :username"
        );
        $this->db->execute([':username' => $username]);
        return $this->db->fetch();
    }

    /**
     * Verificar si email existe
     */
    public function emailExists($email, $excludeId = null) {
        $query = "SELECT id FROM users WHERE email = :email";
        $params = [':email' => $email];

        if ($excludeId) {
            $query .= " AND id != :id";
            $params[':id'] = $excludeId;
        }

        $this->db->prepare($query);
        $this->db->execute($params);
        return $this->db->fetch() !== false;
    }

    /**
     * Verificar si username existe
     */
    public function usernameExists($username, $excludeId = null) {
        $query = "SELECT id FROM users WHERE username = :username";
        $params = [':username' => $username];

        if ($excludeId) {
            $query .= " AND id != :id";
            $params[':id'] = $excludeId;
        }

        $this->db->prepare($query);
        $this->db->execute($params);
        return $this->db->fetch() !== false;
    }

    /**
     * Actualizar usuario
     */
    public function update($id, $data) {
        $fields = [];
        $params = [':id' => $id];

        if (isset($data['full_name'])) {
            $fields[] = "full_name = :full_name";
            $params[':full_name'] = $data['full_name'];
        }
        if (isset($data['bio'])) {
            $fields[] = "bio = :bio";
            $params[':bio'] = $data['bio'];
        }
        if (isset($data['avatar_path'])) {
            $fields[] = "avatar_path = :avatar_path";
            $params[':avatar_path'] = $data['avatar_path'];
        }
        if (isset($data['password'])) {
            $fields[] = "password_hash = :password_hash";
            $params[':password_hash'] = Security::hashPassword($data['password']);
        }
        if (isset($data['role_id'])) {
            $fields[] = "role_id = :role_id";
            $params[':role_id'] = $data['role_id'];
        }

        if (empty($fields)) {
            return true;
        }

        $this->db->prepare(
            "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id"
        );
        return $this->db->execute($params);
    }

    /**
     * Actualizar último login
     */
    public function updateLastLogin($id) {
        $this->db->prepare(
            "UPDATE users SET last_login = NOW() WHERE id = :id"
        );
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Generar token de recuperación de contraseña
     */
    public function setPasswordResetToken($id, $token, $expiresIn = 3600) {
        $this->db->prepare(
            "UPDATE users SET password_reset_token = :token, password_reset_expires = DATE_ADD(NOW(), INTERVAL :expires SECOND) 
             WHERE id = :id"
        );
        return $this->db->execute([
            ':token' => $token,
            ':expires' => $expiresIn,
            ':id' => $id
        ]);
    }

    /**
     * Obtener usuario por token de recuperación
     */
    public function getByPasswordResetToken($token) {
        $this->db->prepare(
            "SELECT * FROM users 
             WHERE password_reset_token = :token AND password_reset_expires > NOW()"
        );
        $this->db->execute([':token' => $token]);
        return $this->db->fetch();
    }

    /**
     * Limpiar token de recuperación
     */
    public function clearPasswordResetToken($id) {
        $this->db->prepare(
            "UPDATE users SET password_reset_token = NULL, password_reset_expires = NULL WHERE id = :id"
        );
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Obtener todos los usuarios con paginación
     */
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;

        $this->db->prepare(
            "SELECT u.*, r.name as role_name 
             FROM users u
             JOIN roles r ON u.role_id = r.id
             ORDER BY u.created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $this->db->execute([
            ':limit' => (int)$limit,
            ':offset' => (int)$offset
        ]);
        return $this->db->fetchAll();
    }

    /**
     * Contar total de usuarios
     */
    public function count() {
        $this->db->prepare("SELECT COUNT(*) as total FROM users");
        $this->db->execute();
        $result = $this->db->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Eliminar usuario
     */
    public function delete($id) {
        $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $this->db->execute([':id' => $id]);
    }

    /**
     * Activar/Desactivar usuario
     */
    public function setActive($id, $active = true) {
        $this->db->prepare(
            "UPDATE users SET is_active = :is_active WHERE id = :id"
        );
        return $this->db->execute([
            ':is_active' => $active ? 1 : 0,
            ':id' => $id
        ]);
    }

    /**
     * Actualizar avatar del usuario
     */
    public function updateAvatar($id, $avatarPath) {
        $this->db->prepare(
            "UPDATE users SET avatar_path = :avatar_path WHERE id = :id"
        );
        return $this->db->execute([
            ':avatar_path' => $avatarPath,
            ':id' => $id
        ]);
    }

    /**
     * Actualizar perfil del usuario
     */
    public function updateProfile($id, $fullName, $bio) {
        $this->db->prepare(
            "UPDATE users SET full_name = :full_name, bio = :bio WHERE id = :id"
        );
        return $this->db->execute([
            ':full_name' => $fullName,
            ':bio' => $bio,
            ':id' => $id
        ]);
    }
}
