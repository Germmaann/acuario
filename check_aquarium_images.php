<?php
require_once 'app/config/config.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=' . DB_CHARSET,
    DB_USER,
    DB_PASS
);
$pdo->exec('USE ' . DB_NAME);

echo "<h2>Verificación de imágenes en acuarios</h2>";

$aquariums = $pdo->query("SELECT id, name FROM aquariums ORDER BY id")->fetchAll();
foreach ($aquariums as $aq) {
    $gallery = $pdo->query("SELECT COUNT(*) as count FROM aquarium_gallery WHERE aquarium_id = {$aq['id']}")->fetch();
    echo "ID: {$aq['id']} | Nombre: {$aq['name']} | Imágenes: {$gallery['count']}<br>";
}

echo "<br><h3>Agregar imagen a Pecera 120 (ID 1)</h3>";

// Obtener usuario
$user = $pdo->query("SELECT id FROM users WHERE username = 'Germman'")->fetch();
$userId = $user['id'] ?? 2;

// Verificar si ya tiene imagen
$existing = $pdo->query("SELECT COUNT(*) as count FROM aquarium_gallery WHERE aquarium_id = 1")->fetch();
if ($existing['count'] == 0) {
    $pdo->prepare("
        INSERT INTO aquarium_gallery (aquarium_id, image_path, title, uploaded_by, created_at)
        VALUES (:aquarium_id, :image_path, :title, :user_id, NOW())
    ")->execute([
        ':aquarium_id' => 1,
        ':image_path' => 'https://picsum.photos/400/300?random=20',
        ':title' => 'Foto Pecera 120',
        ':user_id' => $userId
    ]);
    echo "<p style='color: green;'>✓ Imagen agregada a Pecera 120</p>";
} else {
    echo "<p style='color: blue;'>ℹ Pecera 120 ya tiene {$existing['count']} imagen(es)</p>";
}
?>
