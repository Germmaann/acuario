# Guía de Desarrollo

Información para desarrolladores que deseen mantener o extender el sistema.

## Arquitectura

### Patrón MVC
```
Request → Router → Controller → Model → View → Response
```

### Flujo de Solicitud
1. **index.php** - Punto de entrada único
2. **Router.php** - Mapea URLs a controladores
3. **Controller** - Lógica de negocio
4. **Model** - Interacción con BD
5. **View** - Presentación al usuario

---

## Estructura de Carpetas

```
app/
├── config/
│   └── config.php          # Configuración global
├── lib/
│   ├── Database.php        # PDO singleton
│   ├── Router.php          # Enrutamiento
│   ├── Session.php         # Gestión de sesiones
│   ├── Security.php        # Funciones de seguridad
│   └── Response.php        # Respuestas HTTP
├── models/
│   ├── User.php           # Modelo de usuarios
│   ├── Fish.php           # Modelo de peces
│   ├── Report.php         # Modelo de reportes
│   └── Aquarium.php       # Modelo de acuarios
├── controllers/
│   ├── AuthController.php
│   ├── FishController.php
│   ├── AquariumController.php
│   └── AdminController.php
└── views/
    ├── layouts/
    │   └── main.php       # Layout base
    ├── auth/
    ├── fish/
    ├── aquarium/
    └── admin/
```

---

## Cómo Usar Database.php

### Singleton Pattern
```php
$db = Database::getInstance();
```

### Consulta Preparada
```php
$db->prepare("SELECT * FROM users WHERE id = :id");
$db->execute([':id' => 5]);
$user = $db->fetch(); // Un registro
$users = $db->fetchAll(); // Múltiples registros
```

### Insertar
```php
$db->prepare("INSERT INTO users (username, email) VALUES (:user, :email)");
$db->execute([':user' => 'john', ':email' => 'john@example.com']);
$lastId = $db->lastInsertId();
```

### Actualizar
```php
$db->prepare("UPDATE users SET email = :email WHERE id = :id");
$db->execute([':email' => 'new@example.com', ':id' => 5]);
$affected = $db->rowCount(); // Filas afectadas
```

---

## Cómo Crear un Modelo

```php
class MyModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $this->db->prepare("SELECT * FROM my_table");
        $this->db->execute();
        return $this->db->fetchAll();
    }

    public function getById($id) {
        $this->db->prepare("SELECT * FROM my_table WHERE id = :id");
        $this->db->execute([':id' => $id]);
        return $this->db->fetch();
    }
}
```

---

## Cómo Crear un Controlador

```php
class MyController {
    private $myModel;

    public function __construct() {
        $this->myModel = new MyModel();
    }

    public function index() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $items = $this->myModel->getAll();
        $pageTitle = "Mi Página";
        require BASE_PATH . '/app/views/my_view.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die();
        }

        if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
            Response::json(['success' => false, 'message' => 'Token inválido'], 403);
        }

        // Procesar datos
        // Response::json(['success' => true]);
    }
}
```

---

## Cómo Agregar una Nueva Ruta

En **Router.php**, en la función `mapRoutes()`:

```php
// Para GET
$this->routes['GET']['/mi-ruta'] = ['MiController', 'miMethod'];

// Para POST
$this->routes['POST']['/mi-ruta'] = ['MiController', 'miMethod'];
```

---

## Sistema de Seguridad

### CSRF Protection
```php
// Generar token
$token = Security::generateCsrfToken();

// En vista
<input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

// En controlador
if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
    Response::json(['success' => false], 403);
}
```

### Password Hashing
```php
// Hash
$hash = Security::hashPassword($password);

// Verify
if (Security::verifyPassword($password, $hash)) {
    // Contraseña correcta
}
```

### Sanitización
```php
$clean = Security::sanitize($userInput);
```

---

## Gestión de Sesiones

```php
// Iniciar sesión (automático en index.php)
Session::start();

// Establecer valor
Session::set('user_id', 5);

// Obtener valor
$userId = Session::get('user_id');

// Verificar existencia
if (Session::has('user_id')) { ... }

// Remover valor
Session::remove('user_id');

// Verificar si está logueado
if (Session::isLogged()) { ... }

// Verificar si es admin
if (Session::isAdmin()) { ... }

// Destruir sesión
Session::destroy();
```

---

## Respuestas JSON

```php
// Éxito
Response::json(['success' => true, 'message' => 'OK']);

// Error con código HTTP
Response::json(['success' => false, 'message' => 'Error'], 400);

// Datos
Response::json(['data' => ['id' => 1, 'name' => 'John']]);
```

---

## Respuestas HTTP

```php
// Redireccionar
Response::redirect(APP_URL . '/path');

// Redireccionar atrás
Response::redirectBack();

// 404
Response::notFound();

// 403
Response::forbidden();

// 401
Response::unauthorized();
```

---

## Validación de Datos

```php
// Email
Security::validateEmail('user@example.com'); // true/false

// URL
Security::validateUrl('https://example.com'); // true/false

// Entero positivo
Security::validatePositiveInt(5); // true/false

// Extensión de archivo
Security::validateFileExtension('image.jpg', ['jpg', 'png']);

// MIME type
Security::validateMimeType('/tmp/file', ['image/jpeg']);
```

---

## Logging de Seguridad

```php
Security::logSecurityEvent('LOGIN_SUCCESS', [
    'user_id' => 5,
    'username' => 'john'
]);
```

Los logs se guardan en `logs/security.log`

---

## Manejo de Errores

```php
try {
    $userId = $userModel->create($data);
    if (!$userId) {
        throw new Exception('Error al crear usuario');
    }
} catch (Exception $e) {
    Response::json(['success' => false, 'message' => $e->getMessage()], 500);
}
```

---

## Mejores Prácticas

### ✅ Hacer
- Siempre usar prepared statements
- Validar y sanitizar inputs
- Verificar CSRF tokens
- Verificar permisos de usuario
- Usar hashes para contraseñas
- Registrar eventos importantes
- Usar transacciones para operaciones críticas

### ❌ NO Hacer
- Construir queries con concatenación
- Confiar en inputs del cliente
- Almacenar contraseñas en plain text
- Omitir validación backend
- Mostrar detalles de errores al usuario
- Usar global $_SESSION sin validar

---

## Variables Globales Disponibles

Disponibles en todas las vistas:

```php
APP_NAME              // Nombre de la aplicación
APP_VERSION           // Versión
APP_URL               // URL base
BASE_PATH             // Ruta del proyecto
DATABASE              // Instancia de Database
Session::get(...)     // Valores de sesión
```

---

## Testing

### Crear usuario de prueba
```bash
# En phpMyAdmin, ejecutar:
INSERT INTO users (username, email, password_hash, full_name, role_id)
VALUES ('testuser', 'test@example.com', '$2y$10$...', 'Test User', 2);
```

### Probar API
```bash
curl -X POST http://localhost/acuario/auth/login \
  -d "email=test@example.com&password=test123"
```

---

## Troubleshooting

### Error: "Token de seguridad inválido"
- Verificar que el token CSRF está presente en el formulario
- Verificar que la sesión está iniciada

### Error: "No autorizado"
- Usuario no está logueado
- Agregar verificación `Session::isLogged()`

### Error: "Acceso denegado"
- Usuario no tiene permisos suficientes
- Verificar rol con `Session::isAdmin()`

### Query no devuelve resultados
- Verificar que la tabla existe
- Verificar syntax del SQL
- Usar `echo` para debugging de queries

---

## Extensiones Futuras

### Agregar nuevo modelo
1. Crear archivo en `app/models/`
2. Extender con métodos CRUD
3. Cargar en `index.php`

### Agregar nuevo controlador
1. Crear archivo en `app/controllers/`
2. Agregar rutas en `Router.php`
3. Crear vistas correspondientes

### Agregar nueva tabla
1. Crear migración en `database.sql`
2. Crear modelo para la tabla
3. Crear controlador si es necesario

---

**Última actualización:** 2025-12-20
