<?php
/**
 * Ver logs de error
 * https://acuarix.com/view_logs.php?secret=testing123
 */

if (($_GET['secret'] ?? '') !== 'testing123') {
    http_response_code(403);
    die("Denegado");
}

header('Content-Type: text/html; charset=utf-8');

echo "<pre style='font-family: monospace; background: #f5f5f5; padding: 20px;'>";
echo "=== LOGS DE LA APLICACIÓN ===\n\n";

// Buscar archivos de log
$logsPath = __DIR__ . '/../logs/';

if (is_dir($logsPath)) {
    $files = scandir($logsPath);
    echo "Archivos en ./logs:\n";
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $logsPath . $file;
        $size = filesize($path);
        $date = date('Y-m-d H:i:s', filemtime($path));
        echo "  - $file ($size bytes, última modificación: $date)\n";
    }
} else {
    echo "⚠ Carpeta logs no encontrada\n";
}

echo "\n=== ÚLTIMAS LÍNEAS DE CADA LOG ===\n\n";

// Leer últimas líneas
if (is_dir($logsPath)) {
    $files = glob($logsPath . '*.log');
    foreach ($files as $file) {
        $filename = basename($file);
        echo "Archivo: $filename\n";
        echo "─────────────────────────\n";
        
        // Leer últimas 50 líneas
        $lines = file($file);
        $lastLines = array_slice($lines, -50);
        foreach ($lastLines as $line) {
            echo trim($line) . "\n";
        }
        echo "\n";
    }
}

// Error log del sistema
echo "=== PHP ERROR LOG DEL SISTEMA ===\n";
$errorLog = '/home2/germangu/public_html/error_log';
if (file_exists($errorLog)) {
    $lines = file($errorLog);
    $lastLines = array_slice($lines, -30);
    foreach ($lastLines as $line) {
        echo trim($line) . "\n";
    }
} else {
    echo "⚠ Error log no encontrado en: $errorLog\n";
}

echo "\n=== FIN LOGS ===";
echo "</pre>";
?>
