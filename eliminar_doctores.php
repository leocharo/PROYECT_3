<?php
session_start();

$host = 'localhost';
$db = 'base_asilo';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID del doctor
if (isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Eliminar los registros relacionados en la tabla `usuarios`
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE doctor_id = ?");
        $stmt->bind_param("i", $doctor_id);
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar registros de usuarios: " . $stmt->error);
        }
        $stmt->close();

        // Eliminar el doctor de la tabla `doctores`
        $stmt = $conn->prepare("DELETE FROM doctores WHERE id = ?");
        $stmt->bind_param("i", $doctor_id);
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar el doctor: " . $stmt->error);
        }
        $stmt->close();

        // Confirmar la transacción
        $conn->commit();

        // Redirigir a la página principal después de la eliminación
        header("Location: pagina_inicio.php");
        exit;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        die($e->getMessage());
    }
} else {
    echo "ID del doctor no proporcionado.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
