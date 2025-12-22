<?php
/**
 * Simular el controlador de búsqueda completo
 * https://acuarix.com/test_search_complete.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px; max-width: 100%;'>";
echo "=== SIMULACIÓN COMPLETA DEL CONTROLADOR DE BÚSQUEDA ===\n\n";

// Simular usuario logueado
$_SESSION = ['user_id' => 1];

// Conectar a BD
$host = 'localhost';
$user = 'germangu_acuario';
$pass = 'Romerogerman4';
$db = 'germangu_acuario_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Simular parámetros GET (sin filtros)
    $q = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
    $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
    $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
    
    echo "1. Parámetros recibidos:\n";
    echo "   q: '$q'\n";
    echo "   type: '$type'\n";
    echo "   status: '$status'\n\n";
    
    // Simular lo que hace el controlador
    $userId = $_SESSION['user_id'];
    echo "2. Usuario ID: $userId\n\n";
    
    // Simular la búsqueda
    echo "3. Lógica de búsqueda:\n";
    
    if (!empty($q) || !empty($type) || !empty($status)) {
        echo "   Condición TRUE: llamando a search()\n";
        
        // Simular método search()
        $query = "SELECT * FROM aquariums WHERE user_id = :user_id";
        $params = [':user_id' => $userId];
        
        if (!empty($q)) {
            $query .= " AND name LIKE :search";
            $params[':search'] = "%$q%";
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
        
    } else {
        echo "   Condición FALSE: llamando a getByUser()\n";
        
        // Simular método getByUser()
        $query = "SELECT * FROM aquariums WHERE user_id = :user_id ORDER BY created_at DESC";
        $params = [':user_id' => $userId];
    }
    
    echo "\n4. Ejecutando query:\n";
    echo "   SQL: " . str_replace("\n", " ", $query) . "\n";
    echo "   Params: ";
    echo json_encode($params) . "\n\n";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $aquariums = $stmt->fetchAll();
    
    echo "5. Resultado de \$aquariums:\n";
    echo "   Tipo: " . gettype($aquariums) . "\n";
    echo "   Count: " . count($aquariums) . "\n";
    echo "   Empty: " . (empty($aquariums) ? 'SÍ' : 'NO') . "\n\n";
    
    echo "6. Contenido de \$aquariums:\n";
    if (empty($aquariums)) {
        echo "   ⚠ ARRAY VACÍO - ESTO ES EL PROBLEMA\n";
    } else {
        foreach ($aquariums as $index => $aquarium) {
            echo "   [{$index}] ID: {$aquarium['id']}, Nombre: {$aquarium['name']}\n";
        }
    }
    
    echo "\n7. Test de renderización (lo que hace la vista):\n";
    if (empty($aquariums)) {
        echo "   La vista mostraría: 'No se encontraron acuarios'\n";
    } else {
        echo "   La vista mostraría: '" . count($aquariums) . " acuario(s) encontrado(s)'\n";
        echo "   Y renderizaría " . count($aquariums) . " tarjetas\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== FIN SIMULACIÓN ===";
echo "</pre>";
?>
