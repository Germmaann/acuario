<?php
/**
 * Router de la aplicación
 * Enruta las solicitudes a los controladores correctos
 */

class Router {
    private $routes = [];
    private $currentRoute = null;

    public function __construct() {
        $this->mapRoutes();
    }

    /**
     * Mapear todas las rutas de la aplicación
     */
    private function mapRoutes() {
        // Auth routes
        $this->routes['GET']['/auth/login'] = ['AuthController', 'loginView'];
        $this->routes['POST']['/auth/login'] = ['AuthController', 'login'];
        $this->routes['GET']['/auth/register'] = ['AuthController', 'registerView'];
        $this->routes['POST']['/auth/register'] = ['AuthController', 'register'];
        $this->routes['GET']['/auth/forgot-password'] = ['AuthController', 'forgotPasswordView'];
        $this->routes['POST']['/auth/forgot-password'] = ['AuthController', 'forgotPassword'];
        $this->routes['GET']['/auth/logout'] = ['AuthController', 'logout'];

        // Fish routes (Wiki)
        $this->routes['GET']['/fish'] = ['FishController', 'index'];
        $this->routes['GET']['/fish/show'] = ['FishController', 'show'];
        $this->routes['GET']['/fish/create'] = ['FishController', 'createView'];
        $this->routes['POST']['/fish/create'] = ['FishController', 'create'];
        $this->routes['GET']['/fish/edit'] = ['FishController', 'editView'];
        $this->routes['POST']['/fish/update'] = ['FishController', 'update'];
        $this->routes['POST']['/fish/report'] = ['FishController', 'report'];

        // Aquarium routes
        $this->routes['GET']['/aquarium'] = ['AquariumController', 'index'];
        $this->routes['GET']['/aquarium/public'] = ['AquariumController', 'publicIndex'];
        $this->routes['GET']['/aquarium/show'] = ['AquariumController', 'show'];
        $this->routes['GET']['/aquarium/public-show'] = ['AquariumController', 'publicShow'];
        $this->routes['GET']['/aquarium/create'] = ['AquariumController', 'createView'];
        $this->routes['POST']['/aquarium/create'] = ['AquariumController', 'create'];
        $this->routes['POST']['/aquarium/delete'] = ['AquariumController', 'delete'];
        $this->routes['POST']['/aquarium/toggle-status'] = ['AquariumController', 'toggleStatus'];
        $this->routes['POST']['/aquarium/add-fish'] = ['AquariumController', 'addFish'];
        $this->routes['POST']['/aquarium/add-plant'] = ['AquariumController', 'addPlant'];
        $this->routes['POST']['/aquarium/log-maintenance'] = ['AquariumController', 'logMaintenance'];
        $this->routes['POST']['/aquarium/upload-photo'] = ['AquariumController', 'uploadPhoto'];
        $this->routes['POST']['/aquarium/delete-photo'] = ['AquariumController', 'deletePhoto'];
        $this->routes['GET']['/aquarium/dashboard'] = ['AquariumController', 'dashboard'];
        $this->routes['GET']['/aquarium/search'] = ['AquariumController', 'search'];
        $this->routes['GET']['/aquarium/gallery'] = ['AquariumController', 'gallery'];
        $this->routes['GET']['/aquarium/export-pdf'] = ['AquariumController', 'exportPDF'];

        // Terrarium routes
        $this->routes['GET']['/terrarium'] = ['TerrariumController', 'index'];
        $this->routes['GET']['/terrarium/public'] = ['TerrariumController', 'publicIndex'];
        $this->routes['GET']['/terrarium/show'] = ['TerrariumController', 'show'];
        $this->routes['GET']['/terrarium/public-show'] = ['TerrariumController', 'publicShow'];
        $this->routes['GET']['/terrarium/create'] = ['TerrariumController', 'createView'];
        $this->routes['POST']['/terrarium/create'] = ['TerrariumController', 'create'];
        $this->routes['POST']['/terrarium/delete'] = ['TerrariumController', 'delete'];
        $this->routes['POST']['/terrarium/toggle-status'] = ['TerrariumController', 'toggleStatus'];
        $this->routes['POST']['/terrarium/add-inhabitant'] = ['TerrariumController', 'addInhabitant'];
        $this->routes['POST']['/terrarium/log-maintenance'] = ['TerrariumController', 'logMaintenance'];
        $this->routes['GET']['/terrarium/dashboard'] = ['TerrariumController', 'dashboard'];
        $this->routes['GET']['/terrarium/search'] = ['TerrariumController', 'search'];
        $this->routes['GET']['/terrarium/gallery'] = ['TerrariumController', 'gallery'];
        $this->routes['GET']['/terrarium/export-pdf'] = ['TerrariumController', 'exportPDF'];

        // Admin routes
        $this->routes['GET']['/admin'] = ['AdminController', 'dashboard'];
        $this->routes['GET']['/admin/fish'] = ['AdminController', 'moderateFish'];
        $this->routes['GET']['/admin/moderate-fish'] = ['AdminController', 'moderateFish'];
        $this->routes['POST']['/admin/fish/status'] = ['AdminController', 'updateFishStatus'];
        $this->routes['GET']['/admin/reports'] = ['AdminController', 'reports'];
        $this->routes['POST']['/admin/reports/status'] = ['AdminController', 'updateReportStatus'];
        $this->routes['GET']['/admin/users'] = ['AdminController', 'users'];
        $this->routes['POST']['/admin/users/role'] = ['AdminController', 'changeUserRole'];
        $this->routes['POST']['/admin/users/deactivate'] = ['AdminController', 'deactivateUser'];
        $this->routes['POST']['/admin/users/delete'] = ['AdminController', 'deleteUser'];

        // User profile routes
        $this->routes['GET']['/user/profile'] = ['UserController', 'profile'];
        $this->routes['GET']['/user/public-profile'] = ['UserController', 'publicProfile'];
        $this->routes['POST']['/user/upload-avatar'] = ['UserController', 'uploadAvatar'];
        $this->routes['POST']['/user/remove-avatar'] = ['UserController', 'removeAvatar'];
        $this->routes['POST']['/user/update-profile'] = ['UserController', 'updateProfile'];
        $this->routes['GET']['/user/change-password'] = ['UserController', 'changePasswordView'];
        $this->routes['POST']['/user/change-password'] = ['UserController', 'changePassword'];

        // Alerts and Reports
        $this->routes['GET']['/alerts'] = ['AlertsController', 'index'];
        $this->routes['GET']['/reports'] = ['ReportsController', 'index'];
        $this->routes['GET']['/reports/export-aquariums'] = ['ReportsController', 'exportAquariumsCSV'];
        $this->routes['GET']['/reports/export-terrariums'] = ['ReportsController', 'exportTerrariumsCSV'];
        $this->routes['GET']['/reports/export-maintenance'] = ['ReportsController', 'exportMaintenanceCSV'];

        // Home and Articles routes
        $this->routes['GET']['/'] = ['HomeController', 'index'];
        $this->routes['GET']['/articles'] = ['ArticlesController', 'index'];

        // Deploy webhook routes
        $this->routes['GET']['/webhook/deploy/test'] = ['DeployController', 'test'];
        $this->routes['POST']['/webhook/deploy'] = ['DeployController', 'webhook'];
        $this->routes['GET']['/deploy/log'] = ['DeployController', 'log'];

        // Language switch routes
        $this->routes['GET']['/lang/es'] = ['LangController', 'es'];
        $this->routes['GET']['/lang/en'] = ['LangController', 'en'];

        // Repair deploy route
        $this->routes['GET']['/deploy/repair'] = ['DeployController', 'repair'];

        $this->routes['GET']['/articles/show'] = ['ArticlesController', 'show'];
        $this->routes['GET']['/articles/category'] = ['ArticlesController', 'byCategory'];
        $this->routes['GET']['/articles/create'] = ['ArticlesController', 'createView'];
        $this->routes['POST']['/articles/create'] = ['ArticlesController', 'create'];
        $this->routes['POST']['/articles/update'] = ['ArticlesController', 'update'];
        $this->routes['POST']['/articles/delete'] = ['ArticlesController', 'delete'];
    }

    /**
     * Obtener ruta actual
     */
    private function getCurrentPath() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $appUrl = parse_url(APP_URL, PHP_URL_PATH);

        // Remover APP_URL del inicio si existe (ignorando mayúsculas/minúsculas)
        if (!empty($appUrl) && stripos($path, $appUrl) === 0) {
            $path = substr($path, strlen($appUrl));
        }

        // Remover /public/index.php si está presente
        $path = str_replace('/public/index.php', '', $path);
        $path = str_replace('/index.php', '', $path);

        // Asegurar que empieza con /
        if (empty($path)) {
            $path = '/';
        }

        return $path;
    }

    /**
     * Despachar solicitud al controlador correcto
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->getCurrentPath();

        // Debug: descomentar para ver qué ruta se está solicitando
        // echo "Method: $method, Path: $path<br>";
        // echo "APP_URL: " . APP_URL . "<br>";
        // echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
        // echo "Rutas disponibles: <pre>";
        // print_r($this->routes[$method]);
        // echo "</pre>";
        // exit;


        // Buscar ruta
        if (isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
            return $this->executeRoute($route);
        }

        // Ruta no encontrada
        Response::notFound();
    }

    /**
     * Ejecutar controlador y método
     */
    private function executeRoute($route) {
        list($controllerName, $methodName) = $route;

        // Cargar controlador
        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            die('Controlador no encontrado: ' . $controllerName);
        }

        require_once $controllerFile;

        // Crear instancia de controlador
        $controller = new $controllerName();

        // Ejecutar método
        if (!method_exists($controller, $methodName)) {
            die('Método no encontrado: ' . $methodName);
        }

        return $controller->$methodName();
    }
}
