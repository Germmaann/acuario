<?php
require_once 'app/config/config.php';
require_once 'app/lib/Database.php';
require_once 'app/models/Aquarium.php';
require_once 'app/models/Terrarium.php';

$aquarium = new Aquarium();
$aquariums = $aquarium->getLatestPublic(6);

$terrarium = new Terrarium();
$terrariums = $terrarium->getLatestPublic(6);

echo "Acuarios: " . count($aquariums) . "\n";
echo "Terrarios: " . count($terrariums) . "\n";

if (count($aquariums) > 0) {
    echo "\nPrimer Acuario:\n";
    print_r($aquariums[0]);
}

if (count($terrariums) > 0) {
    echo "\nPrimer Terrario:\n";
    print_r($terrariums[0]);
}
?>
