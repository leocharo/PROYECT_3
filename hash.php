<?php
// Generar el hash de la contraseña
$hashed_password = password_hash('ADMINISTRADOR', PASSWORD_DEFAULT);
echo $hashed_password;
?>
