<?php
// Test para verificar si HomeController funciona
require_once 'app/config/config.php';
require_once 'app/lib/Database.php';
require_once 'app/models/Fish.php';
require_once 'app/models/Aquarium.php';
require_once 'app/models/Terrarium.php';
require_once 'app/models/Article.php';
require_once 'app/controllers/HomeController.php';

echo "<h1>Test HomeController</h1>";

$controller = new HomeController();

// Verificar que el método index existe
if (method_exists($controller, 'index')) {
    echo "<p style='color: green;'>✓ Método index existe</p>";
} else {
    echo "<p style='color: red;'>✗ Método index NO existe</p>";
}

// Ejecutar manualmente las consultas que hace el controlador
$fish = new Fish();
$aquarium = new Aquarium();
$terrarium = new Terrarium();
$article = new Article();

$latestFish = $fish->getLatest(6);
$latestAquariums = $aquarium->getLatestPublic(6);
$latestTerrariums = $terrarium->getLatestPublic(6);
$latestArticles = $article->getLatest(3);

echo "<p>Peces: " . count($latestFish) . "</p>";
echo "<p>Acuarios: " . count($latestAquariums) . "</p>";
echo "<p>Terrarios: " . count($latestTerrariums) . "</p>";
echo "<p>Artículos: " . count($latestArticles) . "</p>";

if (count($latestFish) > 0 && count($latestAquariums) > 0 && count($latestTerrariums) > 0 && count($latestArticles) > 0) {
    echo "<p style='color: green;'><strong>✓ Todos los datos están disponibles</strong></p>";
} else {
    echo "<p style='color: red;'><strong>✗ Falta algún dato</strong></p>";
}
?>
