<?php
/**
 * Configuración de la aplicación
 * Variables de entorno y constantes
 */

// Errores en desarrollo (cambiar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// =====================================================
// CONFIGURACIÓN DE BASE DE DATOS
// =====================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'germangu_acuario');
define('DB_PASS', 'Romerogerman4');
define('DB_NAME', 'germangu_acuario_db');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

// =====================================================
// CONFIGURACIÓN DE LA APLICACIÓN
// =====================================================

define('APP_NAME', 'Sistema de Acuarismo');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'https://acuarix.com/public');
define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');

// Configuración de correo (ajusta con tus credenciales SMTP)
define('MAIL_FROM', 'no-reply@acuario.local');
define('MAIL_FROM_NAME', 'Acuario Recordatorios');
define('MAIL_SMTP_HOST', 'smtp.tu-servidor.com');
define('MAIL_SMTP_PORT', 587);
define('MAIL_SMTP_USER', 'usuario_smtp');
define('MAIL_SMTP_PASS', 'password_smtp');
// Si tu servidor usa TLS/SSL, ajusta estos flags según corresponda
define('MAIL_SMTP_SECURE', 'tls'); // tls | ssl | ''

// =====================================================
// CONFIGURACIÓN DE SEGURIDAD
// =====================================================

define('SESSION_LIFETIME', 3600 * 24); // 24 horas
define('CSRF_TOKEN_LENGTH', 32);

// Salt para hash de contraseñas
define('PASSWORD_ALGO', PASSWORD_BCRYPT);
define('PASSWORD_OPTIONS', ['cost' => 10]);

// =====================================================
// LÍMITES DE SUBIDA DE ARCHIVOS
// =====================================================

define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp', 'gif']);

// =====================================================
// ROLES Y PERMISOS
// =====================================================

define('ROLE_ADMIN', 'admin');
define('ROLE_USER', 'usuario');

// Estados de peces
define('FISH_STATUS_PENDING', 'pendiente');
define('FISH_STATUS_APPROVED', 'aprobado');
define('FISH_STATUS_REJECTED', 'rechazado');

// Estados de reportes
define('REPORT_STATUS_NEW', 'nuevo');
define('REPORT_STATUS_REVIEWING', 'en_revisión');
define('REPORT_STATUS_RESOLVED', 'resuelto');

// Tipos de reportes
define('REPORT_TYPE_DATA', 'datos_incorrectos');
define('REPORT_TYPE_COMPATIBILITY', 'compatibilidad');
define('REPORT_TYPE_IMAGE', 'imagen');
define('REPORT_TYPE_OTHER', 'otro');

// Dificultades
define('DIFFICULTY_VERY_EASY', 'muy_fácil');
define('DIFFICULTY_EASY', 'fácil');
define('DIFFICULTY_MEDIUM', 'medio');
define('DIFFICULTY_HARD', 'difícil');
define('DIFFICULTY_VERY_HARD', 'muy_difícil');

// =====================================================
// RUTAS DE CARPETAS
// =====================================================

define('FISH_UPLOADS_PATH', UPLOADS_PATH . '/fish');
define('GALLERY_UPLOADS_PATH', UPLOADS_PATH . '/gallery');

// Crear carpetas si no existen
if (!is_dir(FISH_UPLOADS_PATH)) {
    @mkdir(FISH_UPLOADS_PATH, 0755, true);
}
if (!is_dir(GALLERY_UPLOADS_PATH)) {
    @mkdir(GALLERY_UPLOADS_PATH, 0755, true);
}
