<?php
/**
 * Test directo del modelo Aquarium usando la clase Database
 * https://acuarix.com/test_aquarium_direct.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== TEST DIRECTO DEL MODELO AQUARIUM ===\n\n";

// Incluir archivos necesarios
require __DIR__ . '/../app/config/config.php';
require __DIR__ . '/../app/lib/Database.php';
require __DIR__ . '/../app/lib/Security.php';
require __DIR__ . '/../app/models/Aquarium.php';

try {
    // Crear instancia del modelo
    $aquariumModel = new Aquarium();
    
    echo "1. Instancia del modelo creada\n\n";
    
    // Test getByUser()
    echo "2. Probando Aquarium::getByUser(1)\n";
    $results = $aquariumModel->getByUser(1);
    echo "   Tipo: " . gettype($results) . "\n";
    echo "   Count: " . count($results) . "\n";
    echo "   Empty: " . (empty($results) ? 'SÍ' : 'NO') . "\n";
    echo "   IsNull: " . (is_null($results) ? 'SÍ' : 'NO') . "\n\n";
    
    if ($results) {
        echo "   Contenido:\n";
        foreach ($results as $aq) {
            echo "     - ID {$aq['id']}: {$aq['name']}\n";
        }
    }
    
    // Test search()
    echo "\n\n3. Probando Aquarium::search(1, '', '', '')\n";
    $results = $aquariumModel->search(1, '', '', '');
    echo "   Tipo: " . gettype($results) . "\n";
    echo "   Count: " . count($results) . "\n";
    echo "   Empty: " . (empty($results) ? 'SÍ' : 'NO') . "\n\n";
    
    if ($results) {
        echo "   Contenido:\n";
        foreach ($results as $aq) {
            echo "     - ID {$aq['id']}: {$aq['name']}\n";
        }
    }
    
    // Test search() con parámetros
    echo "\n\n4. Probando Aquarium::search(1, 'Nano', '', '')\n";
    $results = $aquariumModel->search(1, 'Nano', '', '');
    echo "   Tipo: " . gettype($results) . "\n";
    echo "   Count: " . count($results) . "\n";
    echo "   Empty: " . (empty($results) ? 'SÍ' : 'NO') . "\n\n";
    
    if ($results) {
        echo "   Contenido:\n";
        foreach ($results as $aq) {
            echo "     - {$aq['name']}\n";
        }
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString();
}

echo "\n=== FIN TEST ===";
echo "</pre>";
?>
