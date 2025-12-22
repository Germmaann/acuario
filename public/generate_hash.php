<?php
// Generar hash correcto
$password = 'admin123';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

echo "Contraseña: " . $password . "<br>";
echo "Hash generado: " . $hash . "<br><br>";

echo "SQL para actualizar:<br>";
echo "UPDATE users SET password_hash = '" . $hash . "' WHERE id = 1;<br>";
?>
