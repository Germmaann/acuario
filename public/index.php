<?php
/**
 * Archivo principal de la aplicación
 * index.php - Punto de entrada
 */

// Cargar configuración
require_once __DIR__ . '/../app/config/config.php';

// Iniciar sesión
session_start();

// Cargar clases necesarias
require_once BASE_PATH . '/app/lib/Database.php';
require_once BASE_PATH . '/app/lib/Session.php';
require_once BASE_PATH . '/app/lib/Security.php';
require_once BASE_PATH . '/app/lib/Response.php';
require_once BASE_PATH . '/app/lib/Router.php';

// Cargar modelos
require_once BASE_PATH . '/app/models/User.php';
require_once BASE_PATH . '/app/models/Fish.php';
require_once BASE_PATH . '/app/models/Report.php';
require_once BASE_PATH . '/app/models/Aquarium.php';
require_once BASE_PATH . '/app/models/Terrarium.php';
require_once BASE_PATH . '/app/models/Article.php';

// Cargar controladores
// Los controladores se cargan dinámicamente en el router

// Crear router y despachar
$router = new Router();
$router->dispatch();
