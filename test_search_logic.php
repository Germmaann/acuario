<?php
/**
 * Test local del método search()
 * Simula el comportamiento sin necesidad de base de datos real
 */

// Simulación del método search() con lógica correcta
function searchSimulation($userId, $searchTerm, $type, $status) {
    // Simulación de acuarios
    $mockAquariums = [
        [
            'id' => 1,
            'user_id' => 1,
            'name' => 'Mi Primer Acuario',
            'type' => 'agua_dulce',
            'status' => 'activo'
        ],
        [
            'id' => 2,
            'user_id' => 1,
            'name' => 'Acuario Marino',
            'type' => 'agua_salada',
            'status' => 'activo'
        ],
        [
            'id' => 3,
            'user_id' => 2,
            'name' => 'Otro Acuario',
            'type' => 'brackish',
            'status' => 'inactivo'
        ]
    ];
    
    $results = [];
    
    foreach ($mockAquariums as $aquarium) {
        // Filtro 1: Usuario
        if ($aquarium['user_id'] != $userId) {
            continue;
        }
        
        // Filtro 2: Búsqueda por nombre
        if (!empty($searchTerm) && strpos(strtolower($aquarium['name']), strtolower($searchTerm)) === false) {
            continue;
        }
        
        // Filtro 3: Tipo
        if (!empty($type) && $aquarium['type'] != $type) {
            continue;
        }
        
        // Filtro 4: Estado
        if (!empty($status) && $aquarium['status'] != $status) {
            continue;
        }
        
        $results[] = $aquarium;
    }
    
    return $results;
}

echo "=== TEST LOCAL DE BÚSQUEDA ===\n\n";

// Casos de prueba
$testCases = [
    ['userId' => 1, 'searchTerm' => '', 'type' => '', 'status' => '', 'desc' => 'Sin filtros para user 1'],
    ['userId' => 1, 'searchTerm' => 'Marino', 'type' => '', 'status' => '', 'desc' => 'Buscar "Marino" para user 1'],
    ['userId' => 1, 'searchTerm' => '', 'type' => 'agua_dulce', 'status' => '', 'desc' => 'Filtro agua_dulce para user 1'],
    ['userId' => 1, 'searchTerm' => '', 'type' => 'agua_salada', 'status' => 'activo', 'desc' => 'Filtro agua_salada + activo para user 1'],
    ['userId' => 2, 'searchTerm' => '', 'type' => '', 'status' => '', 'desc' => 'Sin filtros para user 2'],
];

foreach ($testCases as $test) {
    $results = searchSimulation($test['userId'], $test['searchTerm'], $test['type'], $test['status']);
    
    echo "CASO: {$test['desc']}\n";
    echo "  Parámetros: q='{$test['searchTerm']}', type='{$test['type']}', status='{$test['status']}'\n";
    echo "  Resultados: " . count($results) . "\n";
    
    if (count($results) > 0) {
        foreach ($results as $aq) {
            echo "    - {$aq['name']} (ID: {$aq['id']}, type: {$aq['type']}, status: {$aq['status']})\n";
        }
    }
    echo "\n";
}

echo "=== TEST COMPLETADO ===\n";
?>
