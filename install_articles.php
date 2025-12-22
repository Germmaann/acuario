<?php
/**
 * Script para instalar la tabla de artículos
 * Ejecutar: http://localhost/Acuario/install_articles.php
 */

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

    // SQL para crear la tabla de artículos
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS articles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        content LONGTEXT NOT NULL,
        category ENUM('DIY', 'Blog', 'Evento') NOT NULL DEFAULT 'Blog',
        author_id INT NOT NULL,
        image_path VARCHAR(255),
        is_published BOOLEAN DEFAULT FALSE,
        views INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        KEY idx_author_id (author_id),
        KEY idx_category (category),
        KEY idx_is_published (is_published),
        FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    SQL;

    $pdo->exec($sql);
    
    echo "<h2 style='color: #27ae60;'>✓ Tabla de artículos creada exitosamente</h2>";
    echo "<p>La tabla 'articles' ha sido creada en la base de datos.</p>";
    echo "<p><a href='http://localhost/Acuario/'>Volver al inicio</a></p>";
} catch (Exception $e) {
    echo "<h2 style='color: #e74c3c;'>✗ Error al crear la tabla</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='http://localhost/Acuario/'>Volver al inicio</a></p>";
}
?>
