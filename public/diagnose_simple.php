<?php
/**
 * Diagnóstico ultra-simple
 * https://acuarix.com/diagnose_simple.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

header('Content-Type: text/html; charset=utf-8');

// Solo conectar a BD directamente
$host = 'localhost';
$user = 'germangu_acuario';
$pass = 'Romerogerman4';
$db = 'germangu_acuario_db';

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px; border-radius: 5px;'>";
echo "=== DIAGNÓSTICO SIMPLE DE BD ===\n\n";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    echo "✓ Conexión a BD exitosa\n\n";
    
    // Contar acuarios
    $stmt = $conn->query("SELECT COUNT(*) as total FROM aquariums");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total de acuarios: " . $result['total'] . "\n\n";
    
    // Listar todos los acuarios
    echo "Acuarios registrados:\n";
    $stmt = $conn->query("SELECT id, user_id, name, type, status FROM aquariums ORDER BY id");
    $aquariums = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($aquariums)) {
        echo "⚠ NO HAY ACUARIOS\n";
    } else {
        foreach ($aquariums as $aq) {
            echo "  ID {$aq['id']}: user_id {$aq['user_id']} | {$aq['name']} | {$aq['type']} | {$aq['status']}\n";
        }
    }
    
    // Contar usuarios
    echo "\n\nTotal de usuarios: ";
    $stmt = $conn->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $result['total'] . "\n";
    
    // Listar usuarios
    echo "Usuarios registrados:\n";
    $stmt = $conn->query("SELECT id, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user) {
        echo "  ID {$user['id']}: {$user['email']}\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error de conexión: " . $e->getMessage() . "\n";
}

echo "\n=== FIN DIAGNÓSTICO ===";
echo "</pre>";
?>
