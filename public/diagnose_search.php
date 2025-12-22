<?php
/**
 * Diagnóstico completo sin requerir autenticación
 * Accede desde: https://acuarix.com/public/diagnose_search.php?secret=testing123
 */

// Validar que se acceda con un "secret" para evitar exposición de información sensible
$secret = isset($_GET['secret']) ? $_GET['secret'] : '';
if ($secret !== 'testing123') {
    http_response_code(403);
    die("Acceso denegado");
}

header('Content-Type: text/plain; charset=utf-8');

echo "=== DIAGNÓSTICO COMPLETO DE BÚSQUEDA ===\n\n";

// 1. Incluir configuración
echo "1. Cargando configuración...\n";
try {
    require __DIR__ . '/../app/config/config.php';
    echo "   ✓ Configuración cargada\n";
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

// 2. Cargar Database
echo "\n2. Conectando a base de datos...\n";
try {
    require __DIR__ . '/../app/lib/Database.php';
    $db = Database::getInstance();
    echo "   ✓ Conexión exitosa\n";
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

// 3. Verificar tabla aquariums
echo "\n3. Verificando tabla 'aquariums'...\n";
try {
    $stmt = $db->prepare("DESCRIBE aquariums");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "   ✓ Tabla existe con " . count($columns) . " columnas\n";
    echo "   Columnas: " . implode(', ', array_column($columns, 'Field')) . "\n";
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

// 4. Contar acuarios totales
echo "\n4. Contando acuarios totales...\n";
try {
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM aquariums");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total = $result['total'];
    echo "   Total de acuarios en BD: $total\n";
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

// 5. Mostrar primeros 5 acuarios
echo "\n5. Primeros 5 acuarios en BD:\n";
try {
    $stmt = $db->prepare("SELECT id, name, type, status, user_id FROM aquariums LIMIT 5");
    $stmt->execute();
    $aquariums = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($aquariums) === 0) {
        echo "   ⚠ NO HAY ACUARIOS REGISTRADOS\n";
    } else {
        foreach ($aquariums as $aq) {
            echo "   ID {$aq['id']}: {$aq['name']} (user_id: {$aq['user_id']}, type: {$aq['type']}, status: {$aq['status']})\n";
        }
    }
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

// 6. Probar consulta de búsqueda
echo "\n6. Probando consulta SQL de búsqueda:\n";
echo "   Query: SELECT * FROM aquariums WHERE user_id = :user_id LIMIT 1\n";
try {
    $stmt = $db->prepare("SELECT * FROM aquariums WHERE user_id = :user_id LIMIT 1");
    $stmt->execute([':user_id' => 1]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo "   ✓ Encontrado acuario para user_id 1: " . $result['name'] . "\n";
    } else {
        echo "   ⚠ No hay acuarios para user_id 1\n";
    }
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

// 7. Cargar modelo y probar
echo "\n7. Probando método Aquarium::search()...\n";
try {
    require __DIR__ . '/../app/lib/Security.php';
    require __DIR__ . '/../app/models/Aquarium.php';
    
    $model = new Aquarium($db);
    
    // Probar sin filtros
    echo "   a) sin filtros para user_id 1:\n";
    $results = $model->search(1, '', '', '');
    echo "      Resultados: " . count($results) . "\n";
    
    // Probar con búsqueda de nombre
    echo "   b) con búsqueda 'a' para user_id 1:\n";
    $results = $model->search(1, 'a', '', '');
    echo "      Resultados: " . count($results) . "\n";
    
    // Probar con filtro de tipo
    echo "   c) con tipo 'agua_dulce' para user_id 1:\n";
    $results = $model->search(1, '', 'agua_dulce', '');
    echo "      Resultados: " . count($results) . "\n";
    
} catch (Exception $e) {
    die("   ✗ Error: " . $e->getMessage());
}

echo "\n=== FIN DIAGNÓSTICO ===\n";
?>
