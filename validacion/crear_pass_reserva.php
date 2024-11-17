<?php

session_start(); // Start the session to access the CSRF token and session data

// Database connection (if needed)
require '../config/config.php'; // Adjust the path as necessary

// Step 1: CSRF Token Validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $mensaje = "Ocurrio un error. Pongase en contacto con el administrador.";
    } else {
        $errors = [];
        if (empty($_POST['usuario'])) {
            $errors[] = "Sucedio un error.";
        } else {
            $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
        }
        if (empty($_POST['password'])) {
            $errors[] = "El campo 'clave' es obligatorio.";
        } else {
            $password = $_POST['password'];
            if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
                $errors[] = "La clave debe tener al menos 8 caracteres, con al menos una letra y un número.";
            }
        }
        if (empty($_POST['confirm_password'])) {
            $errors[] = "El campo 'confirmar clave' es obligatorio.";
        } else {
            $confirm_password = $_POST['confirm_password'];
            if ($password !== $confirm_password) {
                $errors[] = "Las claves no coinciden.";
            }
        }
        if (!empty($errors)) {
            foreach ($errors as $error) {
                $mensaje .= "<p class='text-danger'>$error</p>";
            }
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            try {
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
                $stmt = $pdo->prepare("UPDATE reservantes SET password = :password, activo = 1, activation_token = NULL WHERE id = :usuario");
                $stmt->execute(['password' => $hashedPassword, 'usuario' => $usuario]);
                $mensaje = "La cuenta ha sido activada con éxito.<br>Por favor, dirijase al <a href='../index.php#contacto'>Login</a>";
            } catch (PDOException $e) {
                $mensaje = "Error: " . $e->getMessage();
            }
        }
    }
} else {
    $mensaje = "Acceso no autorizado";
}

?>

<!DOCTYPE html>
<html lang="es" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITIO_NOMBRE; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
          rel="stylesheet">
    <link href="../static/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="../static/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="../static/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="../static/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
</head>
<body>
<main class="main" id="top">
    <div class="container">
        <div class="row flex-center py-5">
            <div class="col">
                <a class="d-flex flex-center text-decoration-none mb-4" href="ingreso.php">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                            src="../static/imagenes/66_CSIC.jpg"/>
                    </div>
                </a>

                <div class="text-center mb-7">
                    <h3 class="text-body-highlight"><?php echo $mensaje; ?></h3>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../static/vendors/popper/popper.min.js"></script>
<script src="../static/vendors/bootstrap/bootstrap.min.js"></script>
<script src="../static/vendors/anchorjs/anchor.min.js"></script>
<script src="../static/vendors/is/is.min.js"></script>
<script src="../static/vendors/fontawesome/all.min.js"></script>
<script src="../static/vendors/lodash/lodash.min.js"></script>
<script src="../static/vendors/list.js/list.min.js"></script>
<script src="../static/vendors/feather-icons/feather.min.js"></script>
<script src="../static/vendors/dayjs/dayjs.min.js"></script>


</body>

</html>

