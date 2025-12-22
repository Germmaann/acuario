<?php
/**
 * Script para insertar reportes de prueba
 */

require_once 'app/config/config.php';
require_once 'app/lib/Database.php';

$db = Database::getInstance();

// Obtener IDs de peces existentes
$db->prepare("SELECT id FROM fish_wiki LIMIT 5");
$db->execute([]);
$fishes = $db->fetchAll();

if (empty($fishes)) {
    echo "No hay peces en la base de datos. Ejecuta primero insertar_peces_utf8.php\n";
    exit;
}

// Reportes de prueba
$reportes = [
    [
        'fish_id' => $fishes[0]['id'],
        'reporter_id' => 2, // Usuario de prueba
        'report_type' => 'datos_incorrectos',
        'comment' => 'La temperatura mínima indicada es incorrecta. El Guppy puede vivir en temperaturas más bajas, desde 18°C.',
        'status' => 'nuevo'
    ],
    [
        'fish_id' => $fishes[1]['id'],
        'reporter_id' => 2,
        'report_type' => 'compatibilidad',
        'comment' => 'El Betta no es compatible con otros machos de su especie, pero la descripción no es clara sobre la compatibilidad con hembras.',
        'status' => 'en_revisión'
    ],
    [
        'fish_id' => $fishes[2]['id'],
        'reporter_id' => 2,
        'report_type' => 'imagen',
        'comment' => 'La imagen principal no corresponde con la especie descrita.',
        'status' => 'nuevo'
    ],
    [
        'fish_id' => $fishes[3]['id'],
        'reporter_id' => 2,
        'report_type' => 'otro',
        'comment' => 'Falta información sobre el tamaño del acuario recomendado y la esperanza de vida.',
        'status' => 'resuelto'
    ]
];

$sql = "INSERT INTO fish_reports (fish_id, reporter_id, report_type, comment, status) 
        VALUES (:fish_id, :reporter_id, :report_type, :comment, :status)";

$insertados = 0;
foreach ($reportes as $reporte) {
    try {
        $db->prepare($sql)->execute($reporte);
        $insertados++;
    } catch (Exception $e) {
        echo "Error insertando reporte: " . $e->getMessage() . "\n";
    }
}

// Actualizar uno como resuelto con respuesta
if ($insertados > 0) {
    $db->prepare("UPDATE fish_reports SET admin_response = :response, resolved_by = 1 WHERE status = 'resuelto' LIMIT 1");
    $db->execute([':response' => 'Se ha actualizado la ficha con la información faltante sobre tamaño de acuario y esperanza de vida.']);
}

echo "✓ {$insertados} reportes insertados correctamente\n";
echo "\nVisita: http://localhost/acuario/public/admin/reports para gestionar reportes\n";
