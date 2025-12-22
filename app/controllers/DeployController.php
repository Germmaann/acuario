<?php
class DeployController {
    /**
     * Endpoint de prueba para confirmar que la ruta existe
     */
    public function test() {
        header('Content-Type: text/plain');
        echo "Webhook Deploy OK";
        exit;
    }

    /**
     * Endpoint del webhook de GitHub (POST)
     * Verifica firma, revisa rama y ejecuta git pull.
     */
    public function webhook() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Método no permitido';
            return;
        }

        $payload = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

        // Verificar firma
        $expected = 'sha256=' . hash_hmac('sha256', $payload, DEPLOY_SECRET);
        if (!hash_equals($expected, $signature)) {
            http_response_code(403);
            echo 'Firma inválida';
            return;
        }

        $event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
        if ($event !== 'push') {
            echo 'Evento ignorado';
            return;
        }

        $data = json_decode($payload, true);
        $ref = $data['ref'] ?? '';
        $branch = str_replace('refs/heads/', '', $ref);

        if ($branch !== 'main') {
            echo 'Solo se despliega la rama main';
            return;
        }

        // Paths de repo y destino (ajusta si cambia en tu hosting)
        $repoPath = '/home2/germangu/repos/acuario';
        $targetPath = '/home2/germangu/public_html';

        // 1) git pull en el repositorio clonado por cPanel
        $pullCmd = "cd {$repoPath} && git pull origin main 2>&1";
        $pullOutput = function_exists('shell_exec') ? shell_exec($pullCmd) : 'shell_exec deshabilitado';

        // 2) rsync al destino, excluyendo uploads y archivos no deseados
        $rsyncCmd = "rsync -av --delete --exclude='.git' --exclude='.github' --exclude='logs' --exclude='public/uploads' --exclude='.cpanel.yml' --exclude='*.sql' {$repoPath}/ {$targetPath}/ 2>&1";
        $rsyncOutput = function_exists('shell_exec') ? shell_exec($rsyncCmd) : 'shell_exec deshabilitado';

        // Registrar log
        $log = date('Y-m-d H:i:s') . " - Deploy ejecutado\n";
        $log .= "git pull:\n" . trim((string)$pullOutput) . "\n\n";
        $log .= "rsync:\n" . trim((string)$rsyncOutput) . "\n\n";
        @file_put_contents($targetPath . '/deploy.log', $log, FILE_APPEND);

        header('Content-Type: application/json');
        echo json_encode([
            'ok' => true,
            'message' => 'Deploy completado',
            'pull' => $pullOutput,
            'rsync' => $rsyncOutput
        ]);
    }

    /**
     * Mostrar el contenido de deploy.log vía PHP para evitar bloqueos del servidor a archivos .log
     */
    public function log() {
        // Opcional: limitar a admins
        if (class_exists('Session') && !Session::isAdmin()) {
            Response::forbidden('Solo admin puede ver el log');
            return;
        }

        $targetPath = '/home2/germangu/public_html';
        $file = $targetPath . '/deploy.log';
        if (!file_exists($file)) {
            Response::notFound('No existe deploy.log');
            return;
        }

        header('Content-Type: text/plain; charset=utf-8');
        readfile($file);
        exit;
    }

    /**
     * Endpoint para reparar .git corrupto y redeplegar
     * Requiere secret en query parameter
     */
    public function repair() {
        $secret = $_GET['secret'] ?? '';
        if ($secret !== DEPLOY_SECRET) {
            http_response_code(403);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Secret inválido']);
            exit;
        }

        $repoPath = '/home2/germangu/repos/acuario';
        $targetPath = '/home2/germangu/public_html';
        $output = [];

        // 1. Limpiar índice
        if (file_exists($repoPath . '/.git/index')) {
            unlink($repoPath . '/.git/index');
            $output['step1'] = 'Índice limpiado';
        } else {
            $output['step1'] = 'Índice no existe';
        }

        // 2. Reset hard
        $resetCmd = "cd {$repoPath} && git reset --hard HEAD 2>&1";
        $resetOutput = function_exists('shell_exec') ? shell_exec($resetCmd) : 'shell_exec deshabilitado';
        $output['step2'] = trim((string)$resetOutput);

        // 3. Pull
        $pullCmd = "cd {$repoPath} && git pull origin main 2>&1";
        $pullOutput = function_exists('shell_exec') ? shell_exec($pullCmd) : 'shell_exec deshabilitado';
        $output['step3'] = trim((string)$pullOutput);

        // 4. Rsync
        $rsyncCmd = "rsync -av --delete --exclude='.git' --exclude='.github' --exclude='logs' --exclude='public/uploads' --exclude='.cpanel.yml' --exclude='*.sql' {$repoPath}/ {$targetPath}/ 2>&1";
        $rsyncOutput = function_exists('shell_exec') ? shell_exec($rsyncCmd) : 'shell_exec deshabilitado';
        $output['step4'] = trim((string)$rsyncOutput);

        // Log
        $log = date('Y-m-d H:i:s') . " - Repair Deploy ejecutado\n";
        $log .= "Reset: " . $output['step2'] . "\n";
        $log .= "Pull: " . $output['step3'] . "\n";
        $log .= "Rsync: " . $output['step4'] . "\n\n";
        @file_put_contents($targetPath . '/repair_deploy.log', $log, FILE_APPEND);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Repair deploy completado',
            'output' => $output
        ]);
        exit;
    }
}
