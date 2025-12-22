<?php
$password = '123456';
$hash = '$2y$10$N3DN7Fic2lCXh1rfhX4OTuN/FBh3D04weKI/eyRV0vd3wfhswUDmG';

echo 'Testing password verification:<br>';
echo 'Password: ' . $password . '<br>';
echo 'Hash: ' . $hash . '<br>';
$result = password_verify($password, $hash);
echo 'Result: ' . ($result ? 'TRUE' : 'FALSE') . '<br>';

if (!$result) {
    echo '<br>Hash seems invalid. Generating new hash...<br>';
    $newHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    echo 'New hash: ' . $newHash . '<br>';
    echo 'Verify new hash: ' . (password_verify($password, $newHash) ? 'TRUE' : 'FALSE') . '<br>';
}
?>
