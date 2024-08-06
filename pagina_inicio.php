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

// Obtener todos los doctores
$sql = "SELECT id, nombre, especialidad, numero_licencia, foto FROM doctores";
$result = $conn->query($sql);
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctores Asignados</title>
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <link rel="stylesheet" href="fondo.css">
</head>
<body>

<div class="hero">
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
    <div class="cube"></div>
</div>

<!-- Navigation -->
<div class="title-bar" data-responsive-toggle="realEstateMenu" data-hide-for="small">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<div class="top-bar" id="realEstateMenu">
    <div class="top-bar-left">
        <ul class="menu" data-responsive-menu="accordion">
            <li class="menu-text">ASILO LOS SUEÑOS</li>
        </ul>
    </div>
    <div class="top-bar-right">
        <ul class="menu">
            <li><a href="login.php">Cerrar Sesión</a></li>
        </ul>
    </div>
</div>
<!-- /Navigation -->

<br>

<div class="row">

    <div class="medium-7 large-6 columns">
        <h1>PÁGINA PARA ASIGNACIÓN DE DOCTOR Y PACIENTE</h1>
        <button class="button" onclick="window.location.href='agregar-paciente.html'">Agregar Paciente</button>
        <button class="button" onclick="window.location.href='agregar_doctor.html'">Agregar Doctor</button>
    </div>

    <div class="custom-size show-for-large large-3 columns">
        <img src="scss/images/LOGO ASILO.jpg" alt="picture of space">
    </div>
</div>

<div class="row column">
    <hr>
</div>

<div class="row column">
    <p class="lead">Doctores Asignados</p>
</div>

<div class="row small-up-1 medium-up-2 large-up-3">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="column">';
            echo '<div class="callout">';
            echo '<p>' . htmlspecialchars($row['nombre']) . '</p>';
            echo '<p><img src="' . htmlspecialchars($row['foto']) . '" alt="Foto del doctor" style="max-width: 100%; height: auto;"></p>';
            echo '<p class="lead">' . htmlspecialchars($row['nombre']) . '</p>';
            echo '<p class="subheader">Especialidad: ' . htmlspecialchars($row['especialidad']) . '</p>';
            echo '<p class="secondary">Número de Licencia: ' . htmlspecialchars($row['numero_licencia']) . '</p>';

            // Agregar el formulario de eliminación aquí
            echo '<form action="eliminar_doctores.php" method="post" onsubmit="return confirm(\'¿Estás seguro de que deseas eliminar a este doctor?\')">';
            echo '<input type="hidden" name="doctor_id" value="' . htmlspecialchars($row['id']) . '">';
            echo '<button type="submit" class="button alert">Eliminar</button>';
            echo '</form>';

            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron doctores.</p>';
    }
    ?>
</div>

<footer>
    <div class="row expanded callout secondary">
    </footer>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>

<?php
$conn->close();
?>
