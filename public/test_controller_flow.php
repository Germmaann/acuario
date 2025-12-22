<?php
/**
 * Simular exactamente el flujo del controlador
 * https://acuarix.com/test_controller_flow.php?secret=testing123&user_id=1
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== SIMULACIÓN DEL FLUJO DEL CONTROLADOR ===\n\n";

// Simular sesión con usuario específico
$userId = (int)($_GET['user_id'] ?? 1);
$_SESSION = ['user_id' => $userId];

echo "Usuario ID simulado: $userId\n\n";

try {
    // Incluir configuración
    require __DIR__ . '/../app/config/config.php';
    require __DIR__ . '/../app/lib/Database.php';
    require __DIR__ . '/../app/lib/Security.php';
    require __DIR__ . '/../app/models/Aquarium.php';
    
    echo "1. Includes cargados ✓\n\n";
    
    // Crear modelo
    $aquariumModel = new Aquarium();
    echo "2. Modelo creado ✓\n\n";
    
    // Simular parámetros GET
    $searchTerm = '';
    $type = '';
    $status = '';
    
    echo "3. Parámetros: q='$searchTerm', type='$type', status='$status'\n\n";
    
    // Ejecutar la lógica del controlador
    echo "4. Ejecutando lógica de búsqueda:\n";
    
    if (!empty($searchTerm) || !empty($type) || !empty($status)) {
        echo "   Rama: search()\n";
        $aquariums = $aquariumModel->search($userId, $searchTerm, $type, $status);
    } else {
        echo "   Rama: getByUser()\n";
        $aquariums = $aquariumModel->getByUser($userId);
    }
    
    echo "   Resultado: " . count($aquariums) . " acuarios\n\n";
    
    // Verificar que las variables existan
    echo "5. Verificación de variables:\n";
    echo "   \$aquariums definida: " . (isset($aquariums) ? 'SÍ' : 'NO') . "\n";
    echo "   \$aquariums es array: " . (is_array($aquariums) ? 'SÍ' : 'NO') . "\n";
    echo "   \$aquariums vacío: " . (empty($aquariums) ? 'SÍ' : 'NO') . "\n";
    echo "   \$pageTitle definida: " . (isset($pageTitle) ? 'SÍ' : 'NO') . "\n";
    echo "   \$contentView definida: " . (isset($contentView) ? 'SÍ' : 'NO') . "\n\n";
    
    // Establecer las variables como lo hace el controlador
    $pageTitle = 'Buscar Acuarios';
    $contentView = BASE_PATH . '/app/views/aquarium/search-content.php';
    
    echo "6. Variables establecidas:\n";
    echo "   pageTitle: '$pageTitle'\n";
    echo "   contentView: '$contentView'\n";
    echo "   contentView existe: " . (file_exists($contentView) ? 'SÍ' : 'NO') . "\n\n";
    
    // Simular el require de main.php
    echo "7. ¿Qué pasaría al hacer require BASE_PATH . '/app/views/layouts/main.php'?\n";
    $mainFile = BASE_PATH . '/app/views/layouts/main.php';
    echo "   Archivo: $mainFile\n";
    echo "   Existe: " . (file_exists($mainFile) ? 'SÍ' : 'NO') . "\n";
    
    // Intentar hacer un preview de lo que pasaría
    if (file_exists($mainFile)) {
        echo "   Ejecutando require...\n\n";
        ob_start();
        include $mainFile;
        $output = ob_get_clean();
        
        echo "   ✓ Include ejecutado sin errores\n";
        echo "   Primer 200 caracteres del output:\n";
        echo "   " . substr($output, 0, 200) . "...\n\n";
        
        // Buscar el contenido de búsqueda en el output
        if (strpos($output, 'Buscar Acuarios') !== false) {
            echo "   ✓ 'Buscar Acuarios' encontrado en el output\n";
        } else {
            echo "   ⚠ 'Buscar Acuarios' NO encontrado en el output\n";
        }
        
        // Contar cuántas veces aparece el acuario
        $acuarioCount = substr_count($output, 'class="col-lg-4');
        echo "   Tarjetas de acuario encontradas: $acuarioCount\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
    echo "Trace:\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\n=== FIN SIMULACIÓN ===";
echo "</pre>";
?>
