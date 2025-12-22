<?php
/**
 * Script para agregar datos de prueba
 * Aquariums, Terrariums y galerías
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
    
    echo "<h2>Agregando datos de prueba...</h2>";
    
    // Obtener usuario 'Germman'
    $result = $pdo->query("SELECT id FROM users WHERE username = 'Germman'");
    $user = $result->fetch();
    $userId = $user['id'] ?? 2;
    
    // Datos de acuarios de prueba
    $aquariums = [
        ['name' => 'Acuario Comunitario 150L', 'description' => 'Acuario con peces tropicales variados', 'volume' => 150, 'type' => 'agua_dulce'],
        ['name' => 'Nano Acuario 20L', 'description' => 'Acuario pequeño con camarones y plantas', 'volume' => 20, 'type' => 'agua_dulce'],
        ['name' => 'Acuario Discus 180L', 'description' => 'Especializado en cría de peces discus', 'volume' => 180, 'type' => 'agua_dulce'],
        ['name' => 'Acuario Marino 240L', 'description' => 'Arrecife de coral con peces marinos', 'volume' => 240, 'type' => 'agua_salada'],
        ['name' => 'Acuario Amazonas 90L', 'description' => 'Pecera estilo río Amazonas', 'volume' => 90, 'type' => 'agua_dulce'],
    ];
    
    $aquariumIds = [];
    foreach ($aquariums as $aq) {
        $pdo->prepare("
            INSERT INTO aquariums (user_id, name, description, volume_liters, type, status, created_at)
            VALUES (:user_id, :name, :description, :volume, :type, 'activo', NOW())
        ")->execute([
            ':user_id' => $userId,
            ':name' => $aq['name'],
            ':description' => $aq['description'],
            ':volume' => $aq['volume'],
            ':type' => $aq['type']
        ]);
        $aquariumIds[] = $pdo->lastInsertId();
        echo "<p>✓ Acuario creado: {$aq['name']}</p>";
    }
    
    // Datos de terrarios de prueba
    $terrariums = [
        ['name' => 'Terrario Tropical 60x45x45', 'description' => 'Ambiente tropical con plantas y musgos', 'volume' => 120, 'type' => 'tropical'],
        ['name' => 'Terrario Desértico 40x40x40', 'description' => 'Hábitat seco para plantas desérticas', 'volume' => 65, 'type' => 'desértico'],
        ['name' => 'Terrario Húmedo 50x50x60', 'description' => 'Clima húmedo para anfibios', 'volume' => 150, 'type' => 'húmedo'],
        ['name' => 'Terrario Subtropical 45x45x45', 'description' => 'Mezcla de clima seco y húmedo', 'volume' => 90, 'type' => 'subtropical'],
        ['name' => 'Vivario Vertical 30x30x80', 'description' => 'Arreglo vertical con plantas epífitas', 'volume' => 70, 'type' => 'tropical'],
    ];
    
    $terrariumIds = [];
    foreach ($terrariums as $ter) {
        $pdo->prepare("
            INSERT INTO terrariums (user_id, name, description, volume_liters, type, status, created_at)
            VALUES (:user_id, :name, :description, :volume, :type, 'activo', NOW())
        ")->execute([
            ':user_id' => $userId,
            ':name' => $ter['name'],
            ':description' => $ter['description'],
            ':volume' => $ter['volume'],
            ':type' => $ter['type']
        ]);
        $terrariumIds[] = $pdo->lastInsertId();
        echo "<p>✓ Terrario creado: {$ter['name']}</p>";
    }
    
    // Agregar imágenes a galerías (usando URLs de placeholder)
    $count = 0;
    foreach ($aquariumIds as $aqId) {
        for ($i = 1; $i <= 2; $i++) {
            $pdo->prepare("
                INSERT INTO aquarium_gallery (aquarium_id, image_path, title, uploaded_by, created_at)
                VALUES (:aquarium_id, :image_path, :title, :user_id, NOW())
            ")->execute([
                ':aquarium_id' => $aqId,
                ':image_path' => 'aquarium_' . $aqId . '_' . $i . '.jpg',
                ':title' => 'Foto ' . $i,
                ':user_id' => $userId
            ]);
            $count++;
        }
    }
    echo "<p>✓ {$count} imágenes agregadas a galerías de acuarios</p>";
    
    $count = 0;
    foreach ($terrariumIds as $terId) {
        for ($i = 1; $i <= 2; $i++) {
            $pdo->prepare("
                INSERT INTO terrarium_gallery (terrarium_id, image_path, title, uploaded_by, created_at)
                VALUES (:terrarium_id, :image_path, :title, :user_id, NOW())
            ")->execute([
                ':terrarium_id' => $terId,
                ':image_path' => 'terrarium_' . $terId . '_' . $i . '.jpg',
                ':title' => 'Foto ' . $i,
                ':user_id' => $userId
            ]);
            $count++;
        }
    }
    echo "<p>✓ {$count} imágenes agregadas a galerías de terrarios</p>";
    
    echo "<p style='color: green; font-weight: bold;'>✓ Datos de prueba agregados exitosamente</p>";
    echo "<p><a href='debug_data.php'>Ver debug_data.php</a> | <a href='' target='_blank'>Ver página principal</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
