<?php
/**
 * Test del flujo completo CON sesión inicializada
 * https://acuarix.com/test_full_render.php?secret=testing123&user_id=2
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

// IMPORTANTE: Iniciar sesión ANTES de incluir nada
session_start();

// Simular usuario logueado
$_SESSION['user_id'] = (int)($_GET['user_id'] ?? 2);
$_SESSION['logged'] = true;
$_SESSION['lang'] = 'es';

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== TEST FULL RENDER CON SESIÓN ===\n\n";

echo "Sesión iniciada:\n";
echo "  user_id: {$_SESSION['user_id']}\n";
echo "  logged: {$_SESSION['logged']}\n";
echo "  lang: {$_SESSION['lang']}\n\n";

try {
    // Incluir configuración
    require __DIR__ . '/../app/config/config.php';
    require __DIR__ . '/../app/lib/Database.php';
    require __DIR__ . '/../app/lib/Security.php';
    require __DIR__ . '/../app/lib/Response.php';
    require __DIR__ . '/../app/lib/Session.php';
    require __DIR__ . '/../app/lib/I18n.php';
    require __DIR__ . '/../app/models/Aquarium.php';
    
    echo "1. Includes cargados ✓\n\n";
    
    // Inicializar i18n
    I18n::init();
    echo "2. I18n inicializado ✓\n\n";
    
    // Crear modelo y ejecutar búsqueda
    $aquariumModel = new Aquarium();
    $aquariums = $aquariumModel->getByUser($_SESSION['user_id']);
    
    echo "3. Búsqueda ejecutada: " . count($aquariums) . " acuarios ✓\n\n";
    
    // Establecer variables como lo hace el controlador
    $pageTitle = 'Buscar Acuarios';
    $contentView = BASE_PATH . '/app/views/aquarium/search-content.php';
    
    echo "4. Variables establecidas ✓\n";
    echo "   aquariums: " . count($aquariums) . "\n";
    echo "   pageTitle: '$pageTitle'\n";
    echo "   contentView exists: " . (file_exists($contentView) ? 'SÍ' : 'NO') . "\n\n";
    
    // Hacer el include del main.php
    echo "5. Haciendo include de main.php...\n";
    echo "   (Este es el paso que se cuelga en el servidor)\n\n";
    
    $startTime = microtime(true);
    
    ob_start();
    include BASE_PATH . '/app/views/layouts/main.php';
    $output = ob_get_clean();
    
    $endTime = microtime(true);
    $duration = ($endTime - $startTime) * 1000; // en ms
    
    echo "   ✓ Include completado en {$duration}ms\n";
    echo "   Output length: " . strlen($output) . " bytes\n";
    echo "   Contiene 'Buscar Acuarios': " . (strpos($output, 'Buscar Acuarios') !== false ? 'SÍ' : 'NO') . "\n";
    echo "   Contiene acuarios: " . substr_count($output, 'col-lg-4') . " tarjetas\n\n";
    
    // Mostrar primer 500 caracteres del output
    echo "6. Primeros 500 caracteres del HTML:\n";
    echo "   " . substr($output, 0, 500) . "...\n\n";
    
    // Contar elementos HTML importantes
    echo "7. Análisis del HTML:\n";
    echo "   <head>: " . (strpos($output, '<head>') !== false ? 'SÍ' : 'NO') . "\n";
    echo "   <body>: " . (strpos($output, '<body>') !== false ? 'SÍ' : 'NO') . "\n";
    echo "   navbar: " . substr_count($output, 'navbar') . "\n";
    echo "   'No se encontraron acuarios': " . (strpos($output, 'No se encontraron acuarios') !== false ? 'SÍ' : 'NO') . "\n";
    echo "   Acuarios mostrados: " . substr_count($output, 'class=\"card border-0 shadow-sm h-100\"') . "\n";
    
} catch (Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "\nTrace:\n";
    echo $e->getTraceAsString();
}

echo "\n=== FIN TEST ===";
echo "</pre>";
?>
