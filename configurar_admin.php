<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'base_asilo';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generar el hash de la contraseña
$hashed_password = password_hash('ADMINISTRADOR', PASSWORD_DEFAULT);

// Insertar el usuario administrador
$sql = "INSERT INTO usuarios (doctor_id, username, password, rol) 
        VALUES (NULL, 'admin', 'ADMINISTRADOR', 'admin')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario administrador creado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
