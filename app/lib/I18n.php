<?php
class I18n {
    private static $lang = 'es';
    private static $dict = [];

    public static function init() {
        // Detectar idioma por query, sesión o header
        if (isset($_GET['l']) && in_array($_GET['l'], ['es','en'])) {
            Session::set('lang', $_GET['l']);
        }
        $lang = Session::get('lang') ?: self::detectFromHeader();
        self::$lang = in_array($lang, ['es','en']) ? $lang : 'es';

        $file = BASE_PATH . '/app/lang/' . self::$lang . '.php';
        if (file_exists($file)) {
            self::$dict = include $file;
        }
    }

    public static function t($key, $params = []) {
        $text = self::$dict[$key] ?? $key;
        foreach ($params as $k => $v) {
            $text = str_replace('{' . $k . '}', $v, $text);
        }
        return $text;
    }

    public static function getLang() { return self::$lang; }

    private static function detectFromHeader() {
        $al = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
        if (stripos($al, 'en') === 0) return 'en';
        return 'es';
    }
}

// Helper global
function __( $key, $params = [] ) { return I18n::t($key, $params); }
