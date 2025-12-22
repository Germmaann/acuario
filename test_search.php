<?php
require __DIR__ . '/app/config/config.php';
require __DIR__ . '/app/lib/Database.php';
require __DIR__ . '/app/models/Aquarium.php';

// Simular usuario y base de datos
$db = Database::getInstance();

// Crear modelo
$aquariumModel = new Aquarium($db);

// Prueba 1: Búsqueda sin criterios (user_id = 1)
echo "=== PRUEBA 1: Sin criterios ===\n";
$result = $aquariumModel->search(1, '', '', '');
echo "Resultados: " . count($result) . "\n";
var_dump($result);

// Prueba 2: Búsqueda solo por nombre
echo "\n=== PRUEBA 2: Solo por nombre ===\n";
$result = $aquariumModel->search(1, 'test', '', '');
echo "Resultados: " . count($result) . "\n";

// Prueba 3: Solo por tipo
echo "\n=== PRUEBA 3: Solo por tipo ===\n";
$result = $aquariumModel->search(1, '', 'agua_dulce', '');
echo "Resultados: " . count($result) . "\n";

// Prueba 4: Solo por estado
echo "\n=== PRUEBA 4: Solo por estado ===\n";
$result = $aquariumModel->search(1, '', '', 'activo');
echo "Resultados: " . count($result) . "\n";

echo "\n✓ Pruebas completadas\n";
?>
