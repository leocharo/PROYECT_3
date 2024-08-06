<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "base_asilo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$especialidad = $_POST['especialidad'];
$numero_licencia = $_POST['numero_licencia'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña

// Manejo de la imagen
$foto = $_FILES['foto'];
$foto_nombre = basename($foto['name']);
$foto_tmp = $foto['tmp_name'];
$foto_error = $foto['error'];
$foto_tipo = strtolower(pathinfo($foto_nombre, PATHINFO_EXTENSION));

$directorio = 'imagenes_doctores';
$foto_final = $directorio . uniqid() . '.' . $foto_tipo;

// Validar tipo de archivo
if ($foto_error === UPLOAD_ERR_OK) {
    if ($foto_tipo !== 'jpg' && $foto_tipo !== 'jpeg' && $foto_tipo !== 'png') {
        die("Error: Solo se permiten archivos JPG y PNG.");
    }

    if (!move_uploaded_file($foto_tmp, $foto_final)) {
        die("Error al mover el archivo.");
    }
} else {
    die("Error al cargar la imagen.");
}

// Insertar datos en la tabla 'doctores'
$sql_doctor = "INSERT INTO doctores (nombre, especialidad, numero_licencia, foto) VALUES ('$nombre', '$especialidad', '$numero_licencia', '$foto_final')";

if ($conn->query($sql_doctor) === TRUE) {
    $doctor_id = $conn->insert_id; // Obtener el ID del doctor insertado

    // Insertar datos en la tabla 'usuarios'
    $sql_usuario = "INSERT INTO usuarios (doctor_id, username, password) VALUES ('$doctor_id', '$username', '$password')";
    if ($conn->query($sql_usuario) === TRUE) {
        echo "Nuevo doctor agregado exitosamente";
    } else {
        echo "Error: " . $sql_usuario . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_doctor . "<br>" . $conn->error;
}

$conn->close();
?>
