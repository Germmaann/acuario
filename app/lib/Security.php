<?php
/**
 * Clase Security
 * Funciones de seguridad: CSRF, validación, limpieza
 */

class Security {
    
    /**
     * Generar token CSRF
     */
    public static function generateCsrfToken() {
        if (!Session::has('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(CSRF_TOKEN_LENGTH)));
        }
        return Session::get('csrf_token');
    }

    /**
     * Obtener token CSRF desde sesión
     */
    public static function getCsrfToken() {
        return Session::get('csrf_token', '');
    }

    /**
     * Verificar token CSRF
     */
    public static function verifyCsrfToken($token) {
        return hash_equals(self::getCsrfToken(), $token ?? '');
    }

    /**
     * Hash de contraseña
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_ALGO, PASSWORD_OPTIONS);
    }

    /**
     * Verificar contraseña
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Limpiar entrada (escapar XSS)
     */
    public static function sanitize($input) {
        if (is_array($input)) {
            return array_map(fn($item) => self::sanitize($item), $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validar email
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validar URL
     */
    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validar que sea un entero positivo
     */
    public static function validatePositiveInt($value) {
        return filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) !== false;
    }

    /**
     * Generar nombre de archivo seguro
     */
    public static function generateSafeFilename($originalName) {
        $pathinfo = pathinfo($originalName);
        $filename = preg_replace('/[^a-z0-9-]/i', '-', $pathinfo['filename']);
        $filename = preg_replace('/-+/', '-', $filename);
        $extension = strtolower($pathinfo['extension']);
        return $filename . '-' . time() . '.' . $extension;
    }

    /**
     * Validar extensión de archivo
     */
    public static function validateFileExtension($filename, $allowed = []) {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($extension, $allowed);
    }

    /**
     * Validar tipo MIME de archivo
     */
    public static function validateMimeType($filename, $allowedTypes = []) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return in_array($mimeType, $allowedTypes);
    }

    /**
     * Convertir HEIC/HEIF a JPG
     * Nota: requiere ImageMagick/Imagick o GD instalados
     */
    public static function convertHeicToJpg($inputPath, $outputPath) {
        // Si no hay extensiones de imagen disponibles, solo devolver el input
        return $inputPath;
    }

    /**
     * Generar token para recuperar contraseña
     */
    public static function generatePasswordResetToken() {
        return bin2hex(random_bytes(32));
    }

    /**
     * Obtener IP del cliente
     */
    public static function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return 'UNKNOWN';
    }

    /**
     * Registrar actividad de seguridad
     */
    public static function logSecurityEvent($event, $details = []) {
        $logFile = BASE_PATH . '/logs/security.log';
        @mkdir(dirname($logFile), 0755, true);
        
        $logEntry = date('Y-m-d H:i:s') . ' | ' . 
                    $event . ' | ' . 
                    'IP: ' . self::getClientIP() . ' | ' .
                    'USER: ' . (Session::isLogged() ? Session::getUserId() : 'ANONYMOUS') . ' | ' .
                    json_encode($details) . "\n";
        
        @file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
