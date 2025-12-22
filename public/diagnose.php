<?php
/**
 * Script de diagnóstico para debug del 403
 * Acceso: https://acuarix.com/public/diagnose.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Diagnóstico Acuario</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .ok { color: green; }
        .error { color: red; }
        .info { color: blue; }
        pre { background: #f0f0f0; padding: 10px; overflow: auto; }
    </style>
</head>
<body>
    <h1>Diagnóstico de la Aplicación</h1>

    <h2>Permisos de Archivos</h2>
    <?php
    $files = [
        __DIR__ => 'public (actual)',
        dirname(__DIR__) => 'Acuario (raíz)',
        dirname(__DIR__) . '/app' => 'app',
        dirname(__DIR__) . '/app/config' => 'app/config',
        __DIR__ . '/index.php' => 'public/index.php'
    ];

    foreach ($files as $path => $label) {
        if (file_exists($path)) {
            $perms = substr(sprintf('%o', fileperms($path)), -4);
            $readable = is_readable($path) ? '<span class="ok">✓ Readable</span>' : '<span class="error">✗ Not readable</span>';
            $writable = is_writable($path) ? '<span class="ok">✓ Writable</span>' : '<span class="error">✗ Not writable</span>';
            echo "<p><strong>$label</strong> ($perms): $readable | $writable</p>";
        } else {
            echo "<p><strong>$label</strong>: <span class=\"error\">✗ No existe</span></p>";
        }
    }
    ?>

    <h2>Configuración PHP</h2>
    <pre><?php
    echo "PHP Version: " . phpversion() . "\n";
    echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
    echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
    echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
    echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
    echo "mod_rewrite: " . (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()) ? 'Enabled' : 'Unknown') . "\n";
    ?></pre>

    <h2>.htaccess en /public</h2>
    <pre><?php
    $htaccess = __DIR__ . '/.htaccess';
    if (file_exists($htaccess)) {
        echo "✓ Existe\n";
        echo "Contenido:\n";
        echo file_get_contents($htaccess);
    } else {
        echo "✗ No existe";
    }
    ?></pre>

    <h2>index.php en /public</h2>
    <pre><?php
    $index = __DIR__ . '/index.php';
    if (file_exists($index)) {
        echo "✓ Existe (" . filesize($index) . " bytes)";
    } else {
        echo "✗ No existe";
    }
    ?></pre>
</body>
</html>
