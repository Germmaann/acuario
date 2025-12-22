<?php
/**
 * Test específico del modelo Aquarium::search()
 * https://acuarix.com/test_aquarium_model.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== TEST DEL MODELO AQUARIUM ===\n\n";

// Conectar directamente a BD
$host = 'localhost';
$user = 'germangu_acuario';
$pass = 'Romerogerman4';
$db = 'germangu_acuario_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "✓ Conexión a BD exitosa\n\n";
    
    // Test 1: Query directa para user_id 1 sin filtros
    echo "TEST 1: Query directa para user_id 1\n";
    $stmt = $pdo->prepare("SELECT * FROM aquariums WHERE user_id = :user_id ORDER BY created_at DESC");
    $stmt->execute([':user_id' => 1]);
    $results = $stmt->fetchAll();
    echo "Resultados: " . count($results) . "\n";
    foreach ($results as $aq) {
        echo "  - {$aq['name']} (ID: {$aq['id']}, type: {$aq['type']})\n";
    }
    
    // Test 2: Query con filtro de tipo
    echo "\n\nTEST 2: Query con filtro type='agua_dulce'\n";
    $stmt = $pdo->prepare("SELECT * FROM aquariums WHERE user_id = :user_id AND type = :type ORDER BY created_at DESC");
    $stmt->execute([':user_id' => 1, ':type' => 'agua_dulce']);
    $results = $stmt->fetchAll();
    echo "Resultados: " . count($results) . "\n";
    foreach ($results as $aq) {
        echo "  - {$aq['name']} (type: {$aq['type']})\n";
    }
    
    // Test 3: Query con búsqueda LIKE
    echo "\n\nTEST 3: Query con búsqueda LIKE 'Nano'\n";
    $stmt = $pdo->prepare("SELECT * FROM aquariums WHERE user_id = :user_id AND name LIKE :search ORDER BY created_at DESC");
    $stmt->execute([':user_id' => 1, ':search' => '%Nano%']);
    $results = $stmt->fetchAll();
    echo "Resultados: " . count($results) . "\n";
    foreach ($results as $aq) {
        echo "  - {$aq['name']}\n";
    }
    
    // Test 4: Query compleja (lo que hace el método search())
    echo "\n\nTEST 4: Query compleja como en search()\n";
    $userId = 1;
    $searchTerm = '';
    $type = '';
    $status = '';
    
    $query = "SELECT * FROM aquariums WHERE user_id = :user_id";
    $params = [':user_id' => $userId];
    
    if (!empty($searchTerm)) {
        $query .= " AND name LIKE :search";
        $params[':search'] = "%$searchTerm%";
    }
    
    if (!empty($type)) {
        $query .= " AND type = :type";
        $params[':type'] = $type;
    }
    
    if (!empty($status)) {
        $query .= " AND status = :status";
        $params[':status'] = $status;
    }
    
    $query .= " ORDER BY created_at DESC";
    
    echo "Query: " . $query . "\n";
    echo "Params: ";
    print_r($params);
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
    echo "Resultados: " . count($results) . "\n";
    foreach ($results as $aq) {
        echo "  - {$aq['name']} (ID: {$aq['id']})\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== FIN TEST ===";
echo "</pre>";
?>
