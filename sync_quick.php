<?php
/**
 * Script rápido de sincronización para archivos críticos
 * Solo sincroniza archivos PHP, no multimedia
 */

$ftp_host = 'acuarix.com';
$ftp_user = 'german@acuarix.com';
$ftp_pass = 'Romerogerman4';
$ftp_path = 'public_html';

$local_base = __DIR__;

echo "=== SINCRONIZACIÓN RÁPIDA (solo PHP y vistas) ===\n\n";

// Conectar FTP
$ftp = ftp_connect($ftp_host);
if (!$ftp) {
    die("ERROR: No se pudo conectar\n");
}

if (!ftp_login($ftp, $ftp_user, $ftp_pass)) {
    die("ERROR: Credenciales FTP inválidas\n");
}

// Modo pasivo
ftp_pasv($ftp, true);

echo "✓ Conectado a $ftp_host\n\n";

// Archivos y carpetas críticas a sincronizar
$filesToSync = [
    'app/models/Aquarium.php' => 'public_html/app/models/Aquarium.php',
    'app/controllers/AquariumController.php' => 'public_html/app/controllers/AquariumController.php',
    'app/controllers/test_search_debug.php' => 'public_html/app/controllers/test_search_debug.php',
    'app/views/aquarium/search-content.php' => 'public_html/app/views/aquarium/search-content.php',
    'public/diagnose_search.php' => 'public_html/public/diagnose_search.php',
    'sync_ftp.php' => 'public_html/sync_ftp.php',
];

echo "Sincronizando archivos críticos...\n";
$successful = 0;
$failed = 0;

foreach ($filesToSync as $local => $remote) {
    $localPath = $local_base . '/' . $local;
    
    if (!file_exists($localPath)) {
        echo "⊘ $local (no existe localmente)\n";
        $failed++;
        continue;
    }
    
    if (ftp_put($ftp, $remote, $localPath, FTP_BINARY)) {
        echo "✓ $local\n";
        $successful++;
    } else {
        echo "✗ $local\n";
        $failed++;
    }
}

ftp_close($ftp);

echo "\n=== RESULTADO ===\n";
echo "Exitosos: $successful\n";
echo "Fallidos: $failed\n";

if ($successful > 0) {
    echo "\n✓ Sincronización parcial completada\n";
    echo "Verifica https://acuarix.com/aquarium/search en tu navegador\n";
}
?>
