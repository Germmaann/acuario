<?php
/**
 * Clase Database
 * Maneja todas las conexiones PDO y consultas preparadas
 */

class Database {
    private static $instance = null;
    private $connection;
    private $statement;

    /**
     * Constructor privado para implementar Singleton
     */
    private function __construct() {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . 
                   ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('Error de conexión a base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Obtener instancia singleton de la conexión
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Preparar consulta SQL
     */
    public function prepare($query) {
        $this->statement = $this->connection->prepare($query);
        return $this;
    }

    /**
     * Ejecutar consulta con parámetros
     */
    public function execute($params = []) {
        try {
            $this->statement->execute($params);
            return true;
        } catch (PDOException $e) {
            throw new Exception('Error en la consulta: ' . $e->getMessage());
        }
    }

    /**
     * Obtener un registro
     */
    public function fetch() {
        return $this->statement->fetch();
    }

    /**
     * Obtener todos los registros
     */
    public function fetchAll() {
        return $this->statement->fetchAll();
    }

    /**
     * Obtener cantidad de registros afectados
     */
    public function rowCount() {
        return $this->statement->rowCount();
    }

    /**
     * Obtener ID del último registro insertado
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * Iniciar transacción
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }

    /**
     * Confirmar transacción
     */
    public function commit() {
        return $this->connection->commit();
    }

    /**
     * Revertir transacción
     */
    public function rollback() {
        return $this->connection->rollBack();
    }

    /**
     * Método para obtener conexión directa (en casos especiales)
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Evitar clonación de la instancia
     */
    private function __clone() {}

    /**
     * Evitar deserialización de la instancia
     */
    public function __wakeup() {
        throw new Exception('No se puede deserializar una instancia de Database');
    }
}
