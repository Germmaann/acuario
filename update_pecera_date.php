<?php
require_once 'app/config/config.php';

$pdo = new PDO(
    'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=' . DB_CHARSET,
    DB_USER,
    DB_PASS
);
$pdo->exec('USE ' . DB_NAME);

echo "<h2>Actualizando fecha de Pecera 120</h2>";

// Actualizar la fecha de creación de Pecera 120 para que aparezca en los últimos
$pdo->prepare("UPDATE aquariums SET created_at = NOW() WHERE id = 1")->execute();

echo "<p style='color: green;'>✓ Pecera 120 ha sido actualizada a la fecha actual</p>";
echo "<p><a href='/Acuario/'>Ver página principal</a></p>";
?>
