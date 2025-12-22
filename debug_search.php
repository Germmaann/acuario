<?php
/**
 * Debug de búsqueda de acuarios
 */

// Variables de prueba
$_GET['q'] = isset($argv[1]) ? $argv[1] : '';
$_GET['type'] = isset($argv[2]) ? $argv[2] : '';
$_GET['status'] = isset($argv[3]) ? $argv[3] : '';

echo "=== DEBUG BÚSQUEDA ===\n";
echo "Parámetros recibidos:\n";
echo "  q: '" . $_GET['q'] . "'\n";
echo "  type: '" . $_GET['type'] . "'\n";
echo "  status: '" . $_GET['status'] . "'\n\n";

// Simular condición de búsqueda
$searchTerm = $_GET['q'] ?? '';
$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';

echo "Después de sanitization (simulado):\n";
echo "  searchTerm: '" . $searchTerm . "'\n";
echo "  type: '" . $type . "'\n";
echo "  status: '" . $status . "'\n\n";

// Verificar la lógica
if (!empty($searchTerm) || !empty($type) || !empty($status)) {
    echo "✓ Se llama a search()\n";
    
    // Mostrar la query que se construiría
    $query = "SELECT * FROM aquariums WHERE user_id = :user_id";
    $params = [':user_id' => 'USER_ID'];
    
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
    
    echo "\nQuery que se ejecutaría:\n";
    echo $query . "\n\n";
    echo "Parámetros:\n";
    print_r($params);
} else {
    echo "✗ Se llama a getByUser()\n";
}
?>
