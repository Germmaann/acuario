<?php
/**
 * Script de sincronización por FTP
 * Uso: php sync_ftp.php
 * 
 * Configura tus credenciales FTP abajo y ejecuta este script para sincronizar
 * los archivos locales con el servidor.
 */

// === CONFIGURACIÓN FTP ===
$ftp_host = 'acuarix.com'; // Cambiar si es necesario
$ftp_user = 'german@acuarix.com'; // CAMBIAR
$ftp_pass = 'Romerogerman4'; // CAMBIAR
$ftp_path = 'public_html'; // Ruta en el servidor (relativa al home del usuario)

$local_path = __DIR__; // Carpeta local del proyecto (donde está este script)

// === ARCHIVOS A IGNORAR ===
$ignore = ['.git', '.github', 'logs', 'public/uploads', 'node_modules', '.cpanel.yml', '*.sql', '.gitignore', 'sync_ftp.php'];

echo "=== FTP Sync ===\n";
echo "Local: $local_path\n";
echo "Remote: ftp://$ftp_user@$ftp_host$ftp_path\n\n";

// Conectar FTP
echo "Conectando a FTP...\n";
$ftp = ftp_connect($ftp_host);
if (!$ftp) {
    die("ERROR: No se pudo conectar a $ftp_host\n");
}

$login = ftp_login($ftp, $ftp_user, $ftp_pass);
if (!$login) {
    die("ERROR: Credenciales FTP inválidas\n");
}

echo "✓ Conectado a $ftp_host\n\n";

// Cambiar a directorio remoto
if (!ftp_chdir($ftp, $ftp_path)) {
    die("ERROR: No se pudo cambiar a directorio $ftp_path\n");
}

// Función recursiva para sincronizar
function syncDir($localDir, $ftp, $remotePath, $ignore) {
    $files = scandir($localDir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        // Verificar si debe ignorarse
        $shouldIgnore = false;
        foreach ($ignore as $pattern) {
            if ($file === $pattern || fnmatch($pattern, $file)) {
                $shouldIgnore = true;
                break;
            }
        }
        if ($shouldIgnore) continue;
        
        $localFile = $localDir . '/' . $file;
        $remoteFile = $remotePath . '/' . $file;
        
        if (is_dir($localFile)) {
            echo "📁 Directorio: $file\n";
            // Crear directorio remoto si no existe
            if (!@ftp_mkdir($ftp, $remoteFile)) {
                ftp_chdir($ftp, $remoteFile);
            } else {
                ftp_chdir($ftp, $remoteFile);
            }
            syncDir($localFile, $ftp, $remoteFile, $ignore);
            ftp_chdir($ftp, '..');
        } else {
            echo "📄 Archivo: $file";
            if (ftp_put($ftp, $remoteFile, $localFile, FTP_BINARY)) {
                echo " ✓\n";
            } else {
                echo " ✗\n";
            }
        }
    }
}

// Ejecutar sincronización
syncDir($local_path, $ftp, $ftp_path, $ignore);

ftp_close($ftp);
echo "\n✓ Sincronización completada\n";
?>
