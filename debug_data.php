<?php
require_once 'app/config/config.php';
require_once 'app/lib/Database.php';
require_once 'app/models/Fish.php';
require_once 'app/models/Aquarium.php';
require_once 'app/models/Terrarium.php';
require_once 'app/models/Article.php';

echo "<h2>Verificación de Datos</h2>";

// Verificar peces
$fish = new Fish();
$latestFish = $fish->getLatest(6);
echo "<h3>Peces (" . count($latestFish) . ")</h3>";
echo "<pre>" . print_r($latestFish, true) . "</pre>";

// Verificar acuarios
$aquarium = new Aquarium();
$latestAquariums = $aquarium->getLatestPublic(6);
echo "<h3>Acuarios (" . count($latestAquariums) . ")</h3>";
echo "<pre>" . print_r($latestAquariums, true) . "</pre>";

// Verificar terrarios
$terrarium = new Terrarium();
$latestTerrariums = $terrarium->getLatestPublic(6);
echo "<h3>Terrarios (" . count($latestTerrariums) . ")</h3>";
echo "<pre>" . print_r($latestTerrariums, true) . "</pre>";

// Verificar artículos
$article = new Article();
$latestArticles = $article->getLatest(3);
echo "<h3>Artículos (" . count($latestArticles) . ")</h3>";
echo "<pre>" . print_r($latestArticles, true) . "</pre>";
?>
