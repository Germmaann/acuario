<?php
/**
 * Script para instalar tablas faltantes
 * Tablas que faltan: aquarium_gallery, terrarium_gallery
 */

require_once 'app/config/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=' . DB_CHARSET,
        DB_USER,
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Usar la base de datos
    $pdo->exec('USE ' . DB_NAME);
    
    echo "<h2>Instalando tablas faltantes...</h2>";
    
    // Crear tabla aquarium_gallery
    echo "<p><strong>Creando tabla aquarium_gallery...</strong></p>";
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS aquarium_gallery (
            id INT PRIMARY KEY AUTO_INCREMENT,
            aquarium_id INT NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            title VARCHAR(150),
            description TEXT,
            uploaded_by INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            KEY idx_aquarium_id (aquarium_id),
            KEY idx_uploaded_by (uploaded_by),
            FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE,
            FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "<p style='color: green;'>✓ Tabla aquarium_gallery creada exitosamente</p>";
    
    // Verificar si ya existe terrarium_gallery
    $result = $pdo->query("SHOW TABLES LIKE 'terrarium_gallery'");
    if ($result->rowCount() == 0) {
        echo "<p><strong>Creando tabla terrarium_gallery...</strong></p>";
        $pdo->exec("
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "<p style='color: green;'>✓ Tabla terrarium_gallery creada exitosamente</p>";
    } else {
        echo "<p style='color: blue;'>ℹ Tabla terrarium_gallery ya existe</p>";
    }
    
    echo "<p style='color: green; font-weight: bold;'>✓ Todas las tablas han sido instaladas correctamente</p>";
    echo "<p><a href='debug_data.php'>Volver a debug_data.php</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
