<?php
// Script de prueba para debug del login

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar configuración
require 'app/config/config.php';
require 'app/lib/Database.php';
require 'app/lib/Security.php';
require 'app/models/User.php';

echo "<h1>Debug Login</h1>";

// Probar conexión a BD
try {
    $db = new Database();
    $db->prepare("SELECT COUNT(*) as total FROM users");
    $db->execute();
    $result = $db->fetch();
    echo "<p>✅ Conexión a BD OK - Total usuarios: " . $result['total'] . "</p>";
    
    // Mostrar todos los usuarios
    $db->prepare("SELECT id, username, email, is_active FROM users");
    $db->execute();
    $users = $db->fetchAll();
    
    echo "<h3>Usuarios en BD:</h3>";
    echo "<pre>";
    foreach ($users as $user) {
        echo "ID: " . $user['id'] . " | Username: " . $user['username'] . " | Email: " . $user['email'] . " | Activo: " . $user['is_active'] . "\n";
    }
    echo "</pre>";
    
    // Buscar admin específicamente
    echo "<h3>Buscando admin@acuario.local:</h3>";
    $userModel = new User();
    $admin = $userModel->getByEmail('admin@acuario.local');
    
    if ($admin) {
        echo "<p>✅ Admin encontrado:</p>";
        echo "<pre>";
        print_r($admin);
        echo "</pre>";
        
        // Probar verificación de contraseña
        $testPassword = 'admin123';
        $isValid = password_verify($testPassword, $admin['password_hash']);
        echo "<p>Verificación de contraseña 'admin123': " . ($isValid ? '✅ CORRECTA' : '❌ INCORRECTA') . "</p>";
    } else {
        echo "<p>❌ Admin NO encontrado en la BD</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?>
