<?php
/**
 * Script de instalación de tablas de terrarios
 * Ejecuta el SQL necesario para crear las tablas de terrarios
 */

// Configuración de conexión
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'acuario_db';

try {
    // Conectar a la base de datos
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seleccionar la base de datos
    $pdo->exec("USE $database");

    // SQL para crear las tablas
    $sql = <<<SQL
    -- TABLA: terrariums
    CREATE TABLE IF NOT EXISTS terrariums (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        volume_liters DECIMAL(8, 2),
        type ENUM('tropical', 'desértico', 'subtropical', 'húmedo', 'seco') DEFAULT 'tropical',
        dimensions_length DECIMAL(6, 2) COMMENT 'Largo en cm',
        dimensions_width DECIMAL(6, 2) COMMENT 'Ancho en cm',
        dimensions_height DECIMAL(6, 2) COMMENT 'Alto en cm',
        lighting_hours INT,
        heating_type VARCHAR(100),
        humidity_level INT COMMENT 'Porcentaje de humedad',
        temperature_min DECIMAL(3, 1),
        temperature_max DECIMAL(3, 1),
        main_image VARCHAR(255),
        status ENUM('activo', 'inactivo', 'en_construcción') DEFAULT 'activo',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        KEY idx_user_id (user_id),
        KEY idx_status (status),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    -- TABLA: terrarium_inhabitants
    CREATE TABLE IF NOT EXISTS terrarium_inhabitants (
        id INT PRIMARY KEY AUTO_INCREMENT,
        terrarium_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        type VARCHAR(50) COMMENT 'reptil, anfibio, insecto, planta, etc.',
        quantity INT DEFAULT 1,
        notes TEXT,
        added_date DATETIME,
        
        KEY idx_terrarium_id (terrarium_id),
        FOREIGN KEY (terrarium_id) REFERENCES terrariums(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    -- TABLA: terrarium_gallery
    CREATE TABLE IF NOT EXISTS terrarium_gallery (
        id INT PRIMARY KEY AUTO_INCREMENT,
        terrarium_id INT NOT NULL,
        image_path VARCHAR(255) NOT NULL,
        title VARCHAR(150),
        description TEXT,
        uploaded_by INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        
        KEY idx_terrarium_id (terrarium_id),
        KEY idx_uploaded_by (uploaded_by),
        FOREIGN KEY (terrarium_id) REFERENCES terrariums(id) ON DELETE CASCADE,
        FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

    -- TABLA: terrarium_maintenance
    CREATE TABLE IF NOT EXISTS terrarium_maintenance (
        id INT PRIMARY KEY AUTO_INCREMENT,
        terrarium_id INT NOT NULL,
        log_type VARCHAR(50),
        description TEXT,
        reminder_enabled BOOLEAN DEFAULT FALSE,
        reminder_days INT,
        reminder_last_sent DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        
        KEY idx_terrarium_id (terrarium_id),
        KEY idx_created_at (created_at),
        FOREIGN KEY (terrarium_id) REFERENCES terrariums(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    SQL;

    // Ejecutar cada sentencia SQL
    foreach (explode(';', $sql) as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }

    echo '<div style="padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; color: #155724;">';
    echo '<h2>✅ Instalación Exitosa</h2>';
    echo '<p>Las tablas de terrarios se han creado correctamente en la base de datos.</p>';
    echo '<p><strong>Tablas creadas:</strong></p>';
    echo '<ul>';
    echo '<li>terrariums</li>';
    echo '<li>terrarium_inhabitants</li>';
    echo '<li>terrarium_gallery</li>';
    echo '<li>terrarium_maintenance</li>';
    echo '</ul>';
    echo '<p><a href="/acuario/public/terrarium" style="color: #155724; text-decoration: underline; font-weight: bold;">→ Ir a Mis Terrarios</a></p>';
    echo '</div>';

} catch (PDOException $e) {
    echo '<div style="padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24;">';
    echo '<h2>❌ Error en la Instalación</h2>';
    echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p><strong>Código:</strong> ' . htmlspecialchars($e->getCode()) . '</p>';
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalación de Tablas de Terrarios</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h1 {
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>🌿 Instalación de Tablas de Terrarios</h1>
</body>
</html>
