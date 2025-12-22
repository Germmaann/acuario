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
        die('Página no encontrada');
    }

    /**
     * Retornar error 403 (Acceso denegado)
     */
    public static function forbidden() {
        http_response_code(403);
        die('Acceso denegado');
    }

    /**
     * Retornar error 401 (No autorizado)
     */
    public static function unauthorized() {
        http_response_code(401);
        self::redirect(APP_URL . '/auth/login');
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
}
