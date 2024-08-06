<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "Base_Asilo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$edad = $_POST['edad'];
$grupo_sanguineo = $_POST['grupo_sanguineo'];
$alergico_medicamento = $_POST['alergico_medicamento'];
$diagnostico_medico = $_POST['diagnostico_medico'];
$tratamiento = $_POST['tratamiento'];
$medico_responsable = $_POST['medico_responsable'];
$numero_seguro_social = $_POST['numero_seguro_social'];
$familiar_nombre = $_POST['familiar_nombre'];
$familiar_telefono = $_POST['familiar_telefono'];

// Insertar datos en la tabla 'paciente'
$sql = "INSERT INTO paciente (nombre, fecha_nacimiento, edad, grupo_sanguineo, alergico_medicamento, diagnostico_medico, tratamiento, medico_responsable, numero_seguro_social, familiar_nombre, familiar_telefono) 
VALUES ('$nombre', '$fecha_nacimiento', '$edad', '$grupo_sanguineo', '$alergico_medicamento', '$diagnostico_medico', '$tratamiento', '$medico_responsable', '$numero_seguro_social', '$familiar_nombre', '$familiar_telefono')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo paciente agregado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
