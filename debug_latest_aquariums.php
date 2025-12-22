<?php
require_once 'app/config/config.php';
require_once 'app/lib/Database.php';
require_once 'app/models/Aquarium.php';

$aquarium = new Aquarium();
$latest = $aquarium->getLatestPublic(6);

echo "<h2>Últimos Acuarios (getLatestPublic)</h2>";
echo "<pre>";
print_r($latest);
echo "</pre>";

echo "<h2>Verificación de Pecera 120 (ID 1)</h2>";

// Buscar Pecera 120
$pecera120 = null;
foreach ($latest as $aq) {
    if ($aq['id'] == 1) {
        $pecera120 = $aq;
        break;
    }
}

if ($pecera120) {
    echo "<p><strong>Encontrada Pecera 120</strong></p>";
    echo "<p>ID: " . $pecera120['id'] . "</p>";
    echo "<p>Nombre: " . $pecera120['name'] . "</p>";
    echo "<p>Fotos: " . count($pecera120['gallery_photos']) . "</p>";
    echo "<p>Fotos array:</p>";
    echo "<pre>" . print_r($pecera120['gallery_photos'], true) . "</pre>";
} else {
    echo "<p style='color: red;'><strong>NO encontrada Pecera 120 en los 6 más recientes</strong></p>";
    echo "<p>Probablemente esté en una página posterior debido al orden DESC por created_at</p>";
}
?>
