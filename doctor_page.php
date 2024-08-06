<?php
session_start();

$host = 'localhost';
$db = 'base_asilo';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM paciente";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pacientes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" media="all" href="estilo_fondo.css" />
</head>

<body>
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center mb-5">
                    <h2 class="heading-section">Pacientes</h2>
                </div>
            </div>
            <div class="row">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Edad</th>
                            <th>Grupo Sanguíneo</th>
                            <th>Alergias</th>
                            <th>Diagnóstico</th>
                            <th>Tratamiento</th>
                            <th>Médico Responsable</th>
                            <th>Número de Seguro Social</th>
                            <th>Nombre del Familiar</th>
                            <th>Teléfono del Familiar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td data-label="Nombre">' . htmlspecialchars($row['nombre']) . '</td>';
                                echo '<td data-label="Fecha de Nacimiento">' . htmlspecialchars($row['fecha_nacimiento']) . '</td>';
                                echo '<td data-label="Edad">' . htmlspecialchars($row['edad']) . '</td>';
                                echo '<td data-label="Grupo Sanguíneo">' . htmlspecialchars($row['grupo_sanguineo']) . '</td>';
                                echo '<td data-label="Alergias">' . htmlspecialchars($row['alergico_medicamento']) . '</td>';
                                echo '<td data-label="Diagnóstico">' . htmlspecialchars($row['diagnostico_medico']) . '</td>';
                                echo '<td data-label="Tratamiento">' . htmlspecialchars($row['tratamiento']) . '</td>';
                                echo '<td data-label="Médico Responsable">' . htmlspecialchars($row['medico_responsable']) . '</td>';
                                echo '<td data-label="Número de Seguro Social">' . htmlspecialchars($row['numero_seguro_social']) . '</td>';
                                echo '<td data-label="Nombre del Familiar">' . htmlspecialchars($row['familiar_nombre']) . '</td>';
                                echo '<td data-label="Teléfono del Familiar">' . htmlspecialchars($row['familiar_telefono']) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="11">No se encontraron pacientes.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>
