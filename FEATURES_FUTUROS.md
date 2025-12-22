# Este archivo documenta características adicionales que podrían implementarse

## Mejoras Futuras Recomendadas

### 1. Sistema de Notificaciones
```php
// Tabla
CREATE TABLE notifications (
    id INT PRIMARY KEY,
    user_id INT,
    title VARCHAR(255),
    message TEXT,
    type ENUM('info', 'warning', 'error'),
    is_read BOOLEAN,
    created_at TIMESTAMP
);

// Usar para avisar cambios en fichas, nuevos reportes, etc.
```

### 2. Sistema de Ratings/Reseñas
```php
// Tabla
CREATE TABLE fish_ratings (
    id INT PRIMARY KEY,
    fish_id INT,
    user_id INT,
    rating INT (1-5),
    comment TEXT,
    created_at TIMESTAMP
);

// Agregar en vista de pez:
// - Promedio de rating
// - Comentarios de usuarios
```

### 3. Filtros Avanzados en Wiki
```php
// En FishController::index()
// Agregar filtros por:
// - Temperatura
// - pH
// - Tamaño
// - Compatibilidad
// - Origen

public function index() {
    $filters = [
        'temp_min' => $_GET['temp_min'] ?? '',
        'temp_max' => $_GET['temp_max'] ?? '',
        'ph_min' => $_GET['ph_min'] ?? '',
        // ...
    ];
}
```

### 4. Sistema de Comparación de Peces
```html
<!-- Botón en vista de pez -->
<button onclick="addToComparison(<?php echo $fish['id']; ?>)">
    Agregar a Comparación
</button>

<!-- Vista de comparación -->
<table>
    <tr>
        <th>Característica</th>
        <th>Pez 1</th>
        <th>Pez 2</th>
    </tr>
</table>
```

### 5. Exportar a PDF
```php
// Usar biblioteca como TCPDF o Dompdf
// En vista de pez:

public function downloadPdf($fishId) {
    $fish = $this->fishModel->getById($fishId);
    // Generar PDF con info del pez
    Response::download($pdfPath, 'pez_' . $fish['id'] . '.pdf');
}
```

### 6. Galería de Imágenes Avanzada
```php
// Usar lightbox o similar
// Galería con:
// - Zoom
// - Slideshow
// - Descargar
// - Compartir

// Tabla adicional para metadata
CREATE TABLE image_metadata (
    id INT PRIMARY KEY,
    image_id INT,
    camera VARCHAR(100),
    settings VARCHAR(255),
    location VARCHAR(255)
);
```

### 7. Sistema de Mensajería
```php
// Tabla
CREATE TABLE messages (
    id INT PRIMARY KEY,
    from_user_id INT,
    to_user_id INT,
    message TEXT,
    is_read BOOLEAN,
    created_at TIMESTAMP
);

// Permitir contactar a usuarios
// Sistema de inbox/outbox
```

### 8. Geolocalización
```php
// Agregar ubicación a acuarios
ALTER TABLE aquariums ADD COLUMN (
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    city VARCHAR(100)
);

// Mapa de acuarios en la zona
// Conectar con usuarios cercanos
```

### 9. Estadísticas Avanzadas
```php
// Crear tabla para estadísticas
CREATE TABLE statistics (
    id INT PRIMARY KEY,
    date DATE,
    total_fish INT,
    total_users INT,
    total_reports INT
);

// Gráficos con:
// - Crecimiento de usuarios
// - Fichas por dificultad
// - Reportes por mes
// - Uso del sistema
```

### 10. Sistema de Tags/Etiquetas
```php
// Tablas
CREATE TABLE tags (id INT, name VARCHAR(50));
CREATE TABLE fish_tags (fish_id INT, tag_id INT);

// Uso:
// - Filtrar por tags
// - Nubes de tags
// - Búsqueda por tags
```

### 11. Compatibilidad de Acuarios
```php
// Analizar automáticamente compatibilidad entre peces
public function checkCompatibility($aquariumId) {
    $fishes = $this->aquariumModel->getFishes($aquariumId);
    // Analizar datos de compatibilidad
    // Retornar alertas si hay conflictos
}
```

### 12. Importar/Exportar Datos
```php
// Exportar:
// - Datos de acuarios a CSV
// - Ficha de pez a PDF
// - Bitácora de mantenimiento

// Importar:
// - Tabla de compatibilidad
// - Base de datos de peces externa
```

### 13. API RESTful
```php
// Convertir a API JSON completa
// Headers: Accept: application/json
// Response siempre JSON
// Autenticación por token
// Rate limiting
```

### 14. App Móvil
```
// Flutter/React Native
// Sincronizar con servidor
// Modo offline
// Notificaciones push
```

### 15. Integración con Redes Sociales
```php
// Compartir fichas en:
// - Facebook
// - Twitter
// - Instagram

// OAuth para login social
// Importar usuarios de redes
```

---

## Ejemplo: Implementar Sistema de Ratings

### 1. Crear tabla
```sql
CREATE TABLE fish_ratings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fish_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (fish_id) REFERENCES fish_wiki(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_fish (fish_id, user_id)
);
```

### 2. Crear modelo FishRating.php
```php
class FishRating {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create($fishId, $userId, $rating, $comment) {
        $this->db->prepare(
            "INSERT INTO fish_ratings (fish_id, user_id, rating, comment)
             VALUES (:fish_id, :user_id, :rating, :comment)"
        );
        return $this->db->execute([
            ':fish_id' => $fishId,
            ':user_id' => $userId,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    public function getAverageRating($fishId) {
        $this->db->prepare(
            "SELECT AVG(rating) as avg, COUNT(*) as count FROM fish_ratings WHERE fish_id = :fish_id"
        );
        $this->db->execute([':fish_id' => $fishId]);
        return $this->db->fetch();
    }
}
```

### 3. Agregar en FishController
```php
public function rate() {
    if (!Session::isLogged()) {
        Response::unauthorized();
    }

    $fishId = (int)($_POST['fish_id'] ?? 0);
    $rating = (int)($_POST['rating'] ?? 0);

    if ($rating < 1 || $rating > 5) {
        Response::json(['success' => false, 'message' => 'Rating inválido'], 400);
    }

    $ratingModel = new FishRating();
    $result = $ratingModel->create($fishId, Session::getUserId(), $rating, $_POST['comment'] ?? '');
    
    Response::json(['success' => true, 'message' => 'Rating guardado']);
}
```

### 4. Agregar en vista show.php
```php
<?php
$ratingModel = new FishRating();
$avgRating = $ratingModel->getAverageRating($fish['id']);
?>

<h3>Calificación: <?php echo round($avgRating['avg'], 1); ?>/5 (<?php echo $avgRating['count']; ?> votos)</h3>

<?php if (Session::isLogged()): ?>
    <form id="ratingForm">
        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
        <input type="hidden" name="fish_id" value="<?php echo $fish['id']; ?>">
        
        <div>
            <label>Tu calificación:</label>
            <select name="rating" required>
                <option value="">Seleccionar...</option>
                <option value="5">5 ⭐</option>
                <option value="4">4 ⭐</option>
                <option value="3">3 ⭐</option>
                <option value="2">2 ⭐</option>
                <option value="1">1 ⭐</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Calificar</button>
    </form>
<?php endif; ?>
```

---

Estas extensiones mejorarían significativamente la funcionalidad del sistema.

**Última actualización:** 2025-12-20
