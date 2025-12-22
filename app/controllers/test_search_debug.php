<?php
/**
 * Endpoint de diagnóstico de búsqueda
 * Accede desde: https://acuarix.com/app/controllers/test_search_debug.php
 */

// Incluir configuración
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../lib/Database.php';
require __DIR__ . '/../lib/Session.php';
require __DIR__ . '/../lib/Security.php';
require __DIR__ . '/../models/Aquarium.php';

header('Content-Type: text/plain; charset=utf-8');

echo "=== DIAGNÓSTICO DE BÚSQUEDA ===\n\n";

// 1. Verificar si estamos logueados
echo "1. Estado de sesión:\n";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "   Sesión iniciada: " . (session_status() === PHP_SESSION_ACTIVE ? 'SÍ' : 'NO') . "\n";
echo "   Usuario ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NO LOGUEADO') . "\n\n";

if (!isset($_SESSION['user_id'])) {
    die("ERROR: No hay usuario logueado. Loguéate primero.\n");
}

$userId = $_SESSION['user_id'];

// 2. Obtener parámetros de búsqueda
echo "2. Parámetros recibidos:\n";
$searchTerm = isset($_GET['q']) ? Security::sanitize($_GET['q']) : '';
$type = isset($_GET['type']) ? Security::sanitize($_GET['type']) : '';
$status = isset($_GET['status']) ? Security::sanitize($_GET['status']) : '';

echo "   q (búsqueda): '" . $searchTerm . "'\n";
echo "   type: '" . $type . "'\n";
echo "   status: '" . $status . "'\n\n";

// 3. Verificar acuarios del usuario
echo "3. Acuarios del usuario (ID: $userId):\n";
try {
    $db = Database::getInstance();
    $aquariumModel = new Aquarium($db);
    
    $allAquariums = $aquariumModel->getByUser($userId);
    echo "   Total de acuarios: " . count($allAquariums) . "\n";
    
    if (count($allAquariums) > 0) {
        echo "   Acuarios encontrados:\n";
        foreach ($allAquariums as $aq) {
            echo "     - ID " . $aq['id'] . ": " . $aq['name'] . " (tipo: " . $aq['type'] . ", estado: " . $aq['status'] . ")\n";
        }
    } else {
        echo "   ⚠ NO HAY ACUARIOS REGISTRADOS PARA ESTE USUARIO\n";
    }
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

// 4. Probar búsqueda
echo "\n4. Resultado de búsqueda:\n";
try {
    if (!empty($searchTerm) || !empty($type) || !empty($status)) {
        echo "   Llamando a search()...\n";
        $results = $aquariumModel->search($userId, $searchTerm, $type, $status);
        echo "   Resultados: " . count($results) . " acuario(s)\n";
        
        if (count($results) > 0) {
            foreach ($results as $aq) {
                echo "     ✓ " . $aq['name'] . "\n";
            }
        }
    } else {
        echo "   Llamando a getByUser()...\n";
        $results = $allAquariums;
        echo "   Resultados: " . count($results) . " acuario(s)\n";
    }
} catch (Exception $e) {
    echo "   ERROR EN BÚSQUEDA: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DIAGNÓSTICO ===\n";
?>
