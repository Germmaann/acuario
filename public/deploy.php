<?php
// deploy.php - Webhook para desplegar automáticamente desde GitHub

// Verificar token secreto (configúralo en GitHub webhook)
$secret = 'tu_token_secreto_aqui'; // CAMBIA ESTO A UN TOKEN FUERTE

// Verificar signature de GitHub
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$hash = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if ($signature !== $hash) {
    http_response_code(403);
    die('Forbidden');
}

// Obtener evento
$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';

if ($event === 'push') {
    $data = json_decode($payload, true);
    $branch = str_replace('refs/heads/', '', $data['ref']);
    
    // Solo desplegar rama main
    if ($branch === 'main') {
        $output = shell_exec('cd /home/germangu/public_html && git pull origin main 2>&1');
        
        // Log del deploy
        $log = date('Y-m-d H:i:s') . " - Deploy ejecutado\n";
        $log .= "Output: " . trim($output) . "\n\n";
        
        file_put_contents('/home/germangu/public_html/deploy.log', $log, FILE_APPEND);
        
        echo "Deploy completado";
    }
}
?>
