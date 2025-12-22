<?php
/**
 * Capturar TODOS los errores de PHP durante la simulación
 * https://acuarix.com/test_errors_capture.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

// Configurar error reporting máximo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Capturar TODOS los tipos de error
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    global $errors;
    $errors[] = [
        'type' => $errno,
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ];
    return true; // Continuar la ejecución
});

header('Content-Type: text/html; charset=utf-8');

$errors = [];

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== CAPTURA DE ERRORES DE PHP ===\n\n";

try {
    echo "1. Incluye iniciales...\n";
    
    require __DIR__ . '/../app/config/config.php';
    require __DIR__ . '/../app/lib/Database.php';
    require __DIR__ . '/../app/lib/Security.php';
    require __DIR__ . '/../app/models/Aquarium.php';
    
    echo "   ✓ Includes completados\n\n";
    
    echo "2. Creando modelo y ejecutando búsqueda...\n";
    $model = new Aquarium();
    $results = $model->getByUser(1);
    
    echo "   ✓ Búsqueda completada\n";
    echo "   Resultados: " . count($results) . "\n\n";
    
    echo "3. Verificando variables...\n";
    $aquariums = $results;
    $pageTitle = 'Buscar Acuarios';
    $contentView = BASE_PATH . '/app/views/aquarium/search-content.php';
    
    echo "   ✓ Variables establecidas\n";
    echo "   aquariums: " . count($aquariums) . " items\n";
    echo "   pageTitle: '$pageTitle'\n";
    echo "   contentView: '$contentView' (existe: " . (file_exists($contentView) ? 'SÍ' : 'NO') . ")\n\n";
    
    // Hacer un test de require
    echo "4. Test de require de vista...\n";
    ob_start();
    if (file_exists($contentView)) {
        include $contentView;
    }
    $viewOutput = ob_get_clean();
    echo "   ✓ Vista incluida\n";
    echo "   Output length: " . strlen($viewOutput) . " bytes\n";
    echo "   Contiene 'Buscar': " . (strpos($viewOutput, 'Buscar') !== false ? 'SÍ' : 'NO') . "\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n\n";
    echo "Trace:\n";
    echo $e->getTraceAsString();
}

echo "\n\n5. ERRORES CAPTURADOS:\n";
if (empty($errors)) {
    echo "   ✓ NO HAY ERRORES\n";
} else {
    foreach ($errors as $error) {
        $typeNames = [
            E_ERROR => 'ERROR',
            E_WARNING => 'WARNING',
            E_PARSE => 'PARSE',
            E_NOTICE => 'NOTICE',
            E_CORE_ERROR => 'CORE ERROR',
            E_CORE_WARNING => 'CORE WARNING',
            E_COMPILE_ERROR => 'COMPILE ERROR',
            E_COMPILE_WARNING => 'COMPILE WARNING',
            E_USER_ERROR => 'USER ERROR',
            E_USER_WARNING => 'USER WARNING',
            E_USER_NOTICE => 'USER NOTICE',
            E_STRICT => 'STRICT',
            E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
            E_DEPRECATED => 'DEPRECATED',
            E_USER_DEPRECATED => 'USER DEPRECATED'
        ];
        
        $typeName = $typeNames[$error['type']] ?? 'UNKNOWN';
        echo "   [{$typeName}] {$error['message']}\n";
        echo "     en {$error['file']}:{$error['line']}\n";
    }
}

echo "\n=== FIN CAPTURA ===";
echo "</pre>";
?>
