<?php
/**
 * Clase Response
 * Maneja respuestas HTTP y redirecciones
 */

class Response {
    
    /**
     * Establecer mensaje flash en sesión
     */
    public static function setFlash($type, $message) {
        Session::set('flash_' . $type, $message);
    }

    /**
     * Obtener mensaje flash
     */
    public static function getFlash($type) {
        $message = Session::get('flash_' . $type);
        Session::remove('flash_' . $type);
        return $message;
    }

    /**
     * Verificar si existe mensaje flash
     */
    public static function hasFlash($type) {
        return Session::has('flash_' . $type);
    }

    /**
     * Redirigir a una URL
     */
    public static function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    /**
     * Redirigir a la página anterior
     */
    public static function redirectBack() {
        $referer = $_SERVER['HTTP_REFERER'] ?? APP_URL;
        self::redirect($referer);
    }

    /**
     * Retornar error 404
     */
    public static function notFound() {
        http_response_code(404);
        $pageTitle = 'Página no encontrada';
        $contentView = BASE_PATH . '/app/views/errors/404-content.php';
        require BASE_PATH . '/app/views/errors/404.php';
    }

    /**
     * Retornar error 403 (Acceso denegado)
     */
    public static function forbidden() {
        http_response_code(403);
        $pageTitle = 'Acceso denegado';
        $contentView = BASE_PATH . '/app/views/errors/403-content.php';
        require BASE_PATH . '/app/views/errors/403.php';
    }

    /**
     * Retornar error 401 (No autorizado)
     */
    public static function unauthorized() {
        http_response_code(401);
        // Mostrar página 401 con opción a ir al login
        $pageTitle = 'No autorizado';
        $contentView = BASE_PATH . '/app/views/errors/401-content.php';
        require BASE_PATH . '/app/views/errors/401.php';
    }

    /**
     * Retornar JSON
     */
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    /**
     * Descargar archivo
     */
    public static function download($filePath, $fileName) {
        if (!file_exists($filePath)) {
            self::notFound();
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    /**
     * Error 400 (Solicitud inválida)
     */
    public static function badRequest($message = 'Solicitud inválida') {
        http_response_code(400);
        $pageTitle = 'Solicitud inválida';
        $errorMessage = $message;
        $contentView = BASE_PATH . '/app/views/errors/400-content.php';
        require BASE_PATH . '/app/views/errors/400.php';
    }

    /**
     * Error 500 (Error interno)
     */
    public static function serverError($message = 'Error interno del servidor') {
        http_response_code(500);
        $pageTitle = 'Error del servidor';
        $errorMessage = $message;
        $contentView = BASE_PATH . '/app/views/errors/500-content.php';
        require BASE_PATH . '/app/views/errors/500.php';
    }

    /**
     * Error 503 (Servicio no disponible)
     */
    public static function serviceUnavailable($message = 'Servicio temporalmente no disponible') {
        http_response_code(503);
        header('Retry-After: 60');
        $pageTitle = 'Servicio no disponible';
        $errorMessage = $message;
        $contentView = BASE_PATH . '/app/views/errors/503-content.php';
        require BASE_PATH . '/app/views/errors/503.php';
    }
}
