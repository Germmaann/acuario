<?php
/**
 * Script de reparación y despliegue de emergencia
 * Acceso: https://acuarix.com/public/repair_deploy.php
 */

// Variables de servidor
$repoPath = '/home2/germangu/repos/acuario';
$targetPath = '/home2/germangu/public_html';
$secret = 'acuario_webhook_deploy_2025_german_secure';

// Verificar secreto en query
if (!isset($_GET['secret']) || $_GET['secret'] !== $secret) {
    header('HTTP/1.1 403 Forbidden');
    die('Acceso denegado. Secret requerido.');
}

header('Content-Type: application/json');
$output = [];

try {
    // 1. Limpiar índice corrupto
    $output['step1'] = 'Limpiando índice .git corrupto...';
    if (file_exists($repoPath . '/.git/index')) {
        unlink($repoPath . '/.git/index');
        $output['step1'] .= ' OK';
    } else {
        $output['step1'] .= ' (no existe)';
    }

    // 2. Reset hard
    $output['step2'] = 'Ejecutando git reset --hard HEAD...';
    $resetCmd = "cd {$repoPath} && git reset --hard HEAD 2>&1";
    $resetOutput = shell_exec($resetCmd);
    $output['step2_output'] = trim($resetOutput);

    // 3. Git pull
    $output['step3'] = 'Ejecutando git pull origin main...';
    $pullCmd = "cd {$repoPath} && git pull origin main 2>&1";
    $pullOutput = shell_exec($pullCmd);
    $output['step3_output'] = trim($pullOutput);

    // 4. Rsync
    $output['step4'] = 'Ejecutando rsync...';
    $rsyncCmd = "rsync -av --delete --exclude='.git' --exclude='.github' --exclude='logs' --exclude='public/uploads' --exclude='.cpanel.yml' --exclude='*.sql' {$repoPath}/ {$targetPath}/ 2>&1";
    $rsyncOutput = shell_exec($rsyncCmd);
    $output['step4_output'] = trim($rsyncOutput);

    // Registrar en log
    $logMsg = date('Y-m-d H:i:s') . " - Repair Deploy ejecutado\n";
    $logMsg .= "Reset: " . trim($resetOutput) . "\n";
    $logMsg .= "Pull: " . trim($pullOutput) . "\n";
    $logMsg .= "Rsync: " . trim($rsyncOutput) . "\n\n";
    @file_put_contents($targetPath . '/repair_deploy.log', $logMsg, FILE_APPEND);

    $output['status'] = 'success';
    $output['message'] = 'Repair deploy completado exitosamente';

} catch (Exception $e) {
    $output['status'] = 'error';
    $output['message'] = $e->getMessage();
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
