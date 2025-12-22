<?php
/**
 * Script para agregar imágenes de prueba con URLs de placeholder
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
    
    echo "<h2>Agregando imágenes de prueba...</h2>";
    
    // Obtener usuario 'Germman'
    $result = $pdo->query("SELECT id FROM users WHERE username = 'Germman'");
    $user = $result->fetch();
    $userId = $user['id'] ?? 2;
    
    // Obtener acuarios
    $aquariums = $pdo->query("SELECT id FROM aquariums ORDER BY id")->fetchAll();
    $terrariums = $pdo->query("SELECT id FROM terrariums ORDER BY id")->fetchAll();
    
    // URLs de placeholder para acuarios (azul)
    $aquariumPlaceholders = [
        'https://picsum.photos/400/300?random=1',
        'https://picsum.photos/400/300?random=2',
        'https://picsum.photos/400/300?random=3',
        'https://picsum.photos/400/300?random=4',
        'https://picsum.photos/400/300?random=5',
        'https://picsum.photos/400/300?random=6',
    ];
    
    // URLs de placeholder para terrarios (verde)
    $terrariumPlaceholders = [
        'https://picsum.photos/400/300?random=7',
        'https://picsum.photos/400/300?random=8',
        'https://picsum.photos/400/300?random=9',
        'https://picsum.photos/400/300?random=10',
        'https://picsum.photos/400/300?random=11',
        'https://picsum.photos/400/300?random=12',
    ];
    
    // Agregar imágenes a acuarios
    $count = 0;
    foreach ($aquariums as $index => $aquarium) {
        $aqId = $aquarium['id'];
        $image = $aquariumPlaceholders[$index % count($aquariumPlaceholders)];
        
        $pdo->prepare("
            INSERT INTO aquarium_gallery (aquarium_id, image_path, title, uploaded_by, created_at)
            VALUES (:aquarium_id, :image_path, :title, :user_id, NOW())
        ")->execute([
            ':aquarium_id' => $aqId,
            ':image_path' => $image,
            ':title' => 'Foto del acuario',
            ':user_id' => $userId
        ]);
        $count++;
    }
    echo "<p style='color: green;'>✓ {$count} imágenes agregadas a acuarios</p>";
    
    // Agregar imágenes a terrarios
    $count = 0;
    foreach ($terrariums as $index => $terrarium) {
        $terId = $terrarium['id'];
        $image = $terrariumPlaceholders[$index % count($terrariumPlaceholders)];
        
        $pdo->prepare("
            INSERT INTO terrarium_gallery (terrarium_id, image_path, title, uploaded_by, created_at)
            VALUES (:terrarium_id, :image_path, :title, :user_id, NOW())
        ")->execute([
            ':terrarium_id' => $terId,
            ':image_path' => $image,
            ':title' => 'Foto del terrario',
            ':user_id' => $userId
        ]);
        $count++;
    }
    echo "<p style='color: green;'>✓ {$count} imágenes agregadas a terrarios</p>";
    
    echo "<p style='color: green; font-weight: bold;'>✓ Imágenes de prueba agregadas exitosamente</p>";
    echo "<p><a href='/Acuario/aquarium/public'>Ver acuarios</a> | <a href='/Acuario/terrarium/public'>Ver terrarios</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
