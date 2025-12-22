<?php
/**
 * Verificar la sesión REAL del navegador
 * https://acuarix.com/check_session.php
 */

session_start();

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== VERIFICACIÓN DE SESIÓN REAL ===\n\n";

echo "PHPSESSID: " . (isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : 'NO EXISTE') . "\n";
echo "Sesión ID: " . session_id() . "\n\n";

echo "Contenido de \$_SESSION:\n";
if (empty($_SESSION)) {
    echo "  ⚠ \$_SESSION ESTÁ VACÍO - NO ESTÁS LOGUEADO\n";
} else {
    foreach ($_SESSION as $key => $value) {
        if (is_array($value)) {
            echo "  \$_SESSION['$key'] = array(" . count($value) . " items)\n";
        } else {
            echo "  \$_SESSION['$key'] = " . htmlspecialchars($value) . "\n";
        }
    }
}

echo "\n\nSi ves esto:\n";
if (isset($_SESSION['user_id'])) {
    echo "  ✓ user_id: " . $_SESSION['user_id'] . "\n";
    echo "  ✓ Estás logueado como usuario " . $_SESSION['user_id'] . "\n";
} else {
    echo "  ✗ NO ESTÁS LOGUEADO\n";
    echo "  → Debes ir a /login y loguearte primero\n";
}

echo "\n\nPASOS PARA FIJAR EL PROBLEMA:\n";
echo "1. Loguéate en https://acuarix.com/auth/login\n";
echo "2. Luego ejecuta este check: https://acuarix.com/check_session.php\n";
echo "3. Deberías ver tu user_id aquí\n";
echo "4. Luego accede a: https://acuarix.com/aquarium/search\n";

echo "\n=== FIN ===";
echo "</pre>";
?>
