<?php
// Script CLI: enviar recordatorios de mantenimiento vencidos
// Uso: php app/cli/send_reminders.php

require dirname(__DIR__) . '/config/config.php';
require BASE_PATH . '/app/lib/Database.php';
require BASE_PATH . '/app/lib/Mailer.php';

$db = Database::getInstance()->getConnection();
$mailer = new Mailer();

$query = $db->prepare(
    "SELECT ml.id, ml.aquarium_id, ml.log_type, ml.description, ml.reminder_days, ml.reminder_next_at,
            a.name AS aquarium_name,
            u.email, u.full_name
     FROM maintenance_logs ml
     JOIN aquariums a ON ml.aquarium_id = a.id
     JOIN users u ON a.user_id = u.id
     WHERE ml.reminder_enabled = 1
       AND ml.reminder_next_at IS NOT NULL
       AND ml.reminder_next_at <= NOW()"
);

$query->execute();
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

$sent = 0;
$failed = 0;

foreach ($rows as $row) {
    $to = $row['email'];
    $subject = 'Recordatorio de mantenimiento - ' . $row['aquarium_name'];
    $body = "Hola " . ($row['full_name'] ?: 'acuarista') . "\n\n" .
            "Tienes un mantenimiento pendiente para tu acuario: " . $row['aquarium_name'] . "\n" .
            "Tipo: " . $row['log_type'] . "\n" .
            (!empty($row['description']) ? "Detalle: " . $row['description'] . "\n" : '') .
            "Fecha programada: " . $row['reminder_next_at'] . "\n\n" .
            "Este es un recordatorio automático.\n";

    $ok = $mailer->send($to, $subject, $body);
    if ($ok) {
        $sent++;
        if (!empty($row['reminder_days'])) {
            $upd = $db->prepare("UPDATE maintenance_logs SET reminder_next_at = DATE_ADD(reminder_next_at, INTERVAL :days DAY) WHERE id = :id");
            $upd->execute([':days' => (int)$row['reminder_days'], ':id' => $row['id']]);
        }
    } else {
        $failed++;
    }
}

echo "Recordatorios enviados: {$sent}\n";
echo "Fallidos: {$failed}\n";
