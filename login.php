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

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar los valores del formulario
    $usuario = $_POST['username'];
    $contraseña = $_POST['password'];

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular el parámetro
    $stmt->bind_param("s", $usuario);

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener el usuario
        $user_data = $result->fetch_assoc();
        
        // Verificar la contraseña 
        if (password_verify($contraseña, $user_data['password'])) {
            
            session_start();
            $_SESSION['username'] = $usuario;
            $_SESSION['roles'] = $user_data['rol']; // Asumiendo que el rol se guarda en la columna 'rol'

            if ($user_data['rol'] === 'admin') {
                header('Location: pagina_inicio.php'); // Redirigir al admin
            } elseif ($user_data['rol'] === 'user') {
                header('Location: doctor_page.php'); // Redirigir al doctor
            } else {
                // Redirigir a una página de acceso no autorizado o al inicio
                header('Location: login.php');
            }
            exit;
        } else {
            // Contraseña incorrecta
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        // Usuario no encontrado
        $error = "Usuario o contraseña incorrectos";
    }

    // Cerrar la consulta
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Asilo los Sueños</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">ASILO LOS SUEÑOS</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <h3 class="mb-4 text-center">Inicio de Sesión</h3>
                    <form id="loginForm" method="post" action="">
                        <div class="form-group">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Iniciar Sesión</button>
                        </div>
                        <div id="mensaje">
                            <?php if (!empty($error)): ?>
                                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/auth.js"></script>
</body>
</html>
