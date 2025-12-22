<?php
/**
 * Clase Session
 * Maneja todas las operaciones de sesión de usuario
 */

class Session {
    
    /**
     * Iniciar sesión
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => SESSION_LIFETIME,
                'cookie_httponly' => true,
                'cookie_secure' => isset($_SERVER['HTTPS']),
                'cookie_samesite' => 'Lax'
            ]);
        }
    }

    /**
     * Establecer valor en sesión
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Obtener valor de sesión
     */
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Verificar si existe una clave en sesión
     */
    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Eliminar valor de sesión
     */
    public static function remove($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Limpiar toda la sesión
     */
    public static function flush() {
        $_SESSION = [];
    }

    /**
     * Destruir sesión
     */
    public static function destroy() {
        self::flush();
        session_destroy();
    }

    /**
     * Obtener ID de usuario logueado
     */
    public static function getUserId() {
        return self::get('user_id');
    }

    /**
     * Obtener rol del usuario
     */
    public static function getUserRole() {
        return self::get('user_role');
    }

    /**
     * Verificar si usuario está logueado
     */
    public static function isLogged() {
        return self::has('user_id') && !empty(self::get('user_id'));
    }

    /**
     * Verificar si es administrador
     */
    public static function isAdmin() {
        return self::isLogged() && self::get('user_role') === ROLE_ADMIN;
    }
}
