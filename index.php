<?php
/**
 * Proxy/Bootstrap en raíz que sirve la app desde /public/
 * Esto evita el 403 de cPanel en /public/
 */

// Mapear las rutas de /public/ hacia aquí
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remover /public si está al inicio
if (strpos($requestUri, '/public/') === 0) {
    $requestUri = substr($requestUri, 7); // Remover '/public'
}

// Construir la ruta interna hacia /public/
if (empty($requestUri) || $requestUri === '/') {
    $file = __DIR__ . '/public/index.php';
} else {
    $file = __DIR__ . '/public' . $requestUri;
}

// Si es un archivo existente (css, js, etc), servir directamente
if (file_exists($file) && is_file($file)) {
    // Determinar Content-Type
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $types = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'php' => 'text/html'
    ];
    
    $contentType = $types[$ext] ?? 'text/plain';
    header('Content-Type: ' . $contentType);
    readfile($file);
    exit;
}

// Si es un directorio, cargar index.php
if (file_exists($file) && is_dir($file)) {
    $file = $file . '/index.php';
}

// Ejecutar /public/index.php como punto de entrada
if (file_exists($file)) {
    // Inyectar REQUEST_URI corregida
    $_SERVER['REQUEST_URI'] = '/public' . $requestUri;
    require $file;
} else {
    http_response_code(404);
    echo "404 Not Found";
}
