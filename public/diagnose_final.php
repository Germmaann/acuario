<?php
/**
 * Diagnóstico FINAL: Simular exactamente la ruta /aquarium/search
 * https://acuarix.com/diagnose_final.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

// Iniciar sesión
session_start();

// Obtener cookies de sesión del navegador si existen
header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== DIAGNÓSTICO FINAL ===\n\n";

echo "1. Estado actual de la sesión:\n";
echo "   PHPSESSID: " . (isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : 'NO EXISTE') . "\n";
echo "   user_id en sesión: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NO EXISTE') . "\n";
echo "   logged en sesión: " . (isset($_SESSION['logged']) ? $_SESSION['logged'] : 'NO EXISTE') . "\n";
echo "   lang en sesión: " . (isset($_SESSION['lang']) ? $_SESSION['lang'] : 'NO EXISTE') . "\n\n";

// Conectar a BD
$host = 'localhost';
$user = 'germangu_acuario';
$pass = 'Romerogerman4';
$db = 'germangu_acuario_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    
    echo "2. Usuarios en la base de datos:\n";
    $stmt = $pdo->query("SELECT id, email FROM users ORDER BY id");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $user) {
        echo "   User ID {$user['id']}: {$user['email']}\n";
    }
    
    echo "\n3. Acuarios por usuario:\n";
    $stmt = $pdo->query("SELECT user_id, COUNT(*) as total FROM aquariums GROUP BY user_id");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "   User {$row['user_id']}: {$row['total']} acuarios\n";
    }
    
    echo "\n4. Test de búsqueda para cada usuario:\n";
    for ($uid = 1; $uid <= 3; $uid++) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM aquariums WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $uid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "   User {$uid}: " . $result['total'] . " acuarios\n";
    }
    
    echo "\n5. Si el usuario logueado es user_id=1:\n";
    require __DIR__ . '/../app/config/config.php';
    require __DIR__ . '/../app/lib/Database.php';
    require __DIR__ . '/../app/models/Aquarium.php';
    
    $model = new Aquarium();
    $aquariums = $model->getByUser(1);
    echo "   getByUser(1): " . count($aquariums) . " acuarios\n";
    
    echo "\n6. Si el usuario logueado es user_id=2:\n";
    $aquariums = $model->getByUser(2);
    echo "   getByUser(2): " . count($aquariums) . " acuarios\n";
    
    echo "\n7. Test: Renderizar búsqueda para user_id=1 con 6 acuarios:\n";
    $_SESSION['user_id'] = 1;
    $_SESSION['logged'] = true;
    $_SESSION['lang'] = 'es';
    
    require __DIR__ . '/../app/lib/Session.php';
    require __DIR__ . '/../app/lib/I18n.php';
    require __DIR__ . '/../app/lib/Response.php';
    require __DIR__ . '/../app/lib/Security.php';
    
    I18n::init();
    
    $aquariums = $model->getByUser(1);
    $pageTitle = 'Buscar Acuarios';
    $contentView = BASE_PATH . '/app/views/aquarium/search-content.php';
    
    ob_start();
    include BASE_PATH . '/app/views/layouts/main.php';
    $output = ob_get_clean();
    
    echo "   Acuarios en HTML: " . substr_count($output, 'class="col-lg-4') . "\n";
    echo "   'Nano Plantado' en HTML: " . (strpos($output, 'Nano Plantado') ? 'SÍ' : 'NO') . "\n";
    echo "   Output length: " . strlen($output) . " bytes\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "\n=== FIN DIAGNÓSTICO ===";
echo "</pre>";
?>
