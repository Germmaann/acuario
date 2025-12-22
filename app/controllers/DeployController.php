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

        // Ejecutar git pull en el path del public_html.
        // Nota: en algunos hostings shell_exec puede estar deshabilitado.
        $cmd = 'cd /home2/germangu/public_html && git pull origin main 2>&1';
        $output = function_exists('shell_exec') ? shell_exec($cmd) : 'shell_exec deshabilitado';

        // Registrar log
        $log = date('Y-m-d H:i:s') . " - Deploy ejecutado\n";
        $log .= "Output: " . trim((string)$output) . "\n\n";
        @file_put_contents('/home2/germangu/public_html/deploy.log', $log, FILE_APPEND);

        header('Content-Type: application/json');
        echo json_encode(['ok' => true, 'message' => 'Deploy completado', 'output' => $output]);
    }
}
