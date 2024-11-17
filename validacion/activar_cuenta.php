<?php
session_start();
include("../config/config.php");
include("../clases/clase_csic.php");

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csic = new Csic();

if (isset($_GET['gestion'])) {
    $csic->storeFormValues($_GET);
    $res = $csic->activar_reservante();
} else {
    header("location:error.php");
    exit;
}

if (!$res) {
    header("location:error.php");
    exit;
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
                            src="../static/imagenes/<?php echo LOGO_INSTITUCIONAL ; ?>"/>
                    </div>
                </a>

                <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Bienvenido, por favor, setee su contraseña para ingresar al
                        sistema.</h3>
                    <small>La clave debe tener al menos 8 caracteres, con al menos una letra y un número.</small>
                </div>
            </div>
        </div>
        <div class="row flex-center py-5">
            <div class="col-6">
                <form id="loginForm" action="crear_pass_reserva.php" method="POST">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="usuario" value="<?php echo $res; ?>">

                    <!-- Password Field -->
                    <div class="mb-3 text-start form-group" id="password-group">
                        <label class="form-label" for="password">Clave</label>
                        <div class="form-icon-container position-relative" data-password="data-password">
                            <input class="form-control form-icon-input pe-6" id="password1" name="password" type="password"
                                   placeholder="Clave" required/>
                            <span class="fas fa-key text-body fs-9 form-icon"></span>
                            <button type="button"
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                <span class="uil uil-eye show"></span>
                                <span class="uil uil-eye-slash hide"></span>
                            </button>
                        </div>
                        <span class="error-message text-danger" id="password-error"></span>
                        <span class="strength-message text-warning" id="password-strength"></span>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-3 text-start form-group" id="confirm-password-group">
                        <label class="form-label" for="password">Confirmar Clave</label>
                        <div class="form-icon-container position-relative" data-password="data-password">
                            <input class="form-control form-icon-input pe-6" id="password2" name="confirm_password"
                                   type="password" placeholder="Confirmar Clave" required/>
                            <span class="fas fa-key text-body fs-9 form-icon"></span>
                            <button type="button"
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle">
                                <span class="uil uil-eye show"></span>
                                <span class="uil uil-eye-slash hide"></span>
                            </button>
                        </div>
                        <span class="error-message text-danger" id="confirm-password-error"></span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3" id="btn_ingreso">Generar</button>
                </form>

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

<script>
    $(document).ready(function () {
        // Toggle password visibility for each password field
        $('[data-password-toggle]').on('click', function () {
            var passwordInput = $(this).siblings('input');
            var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('.uil').toggleClass('show hide');
        });

        // Password strength validation
        $('#password1').on('input', function () {
            var password = $(this).val();
            var strengthMessage = $('#password-strength');

            if (password.length < 6) {
                strengthMessage.text('Muy débil').css('color', 'red');
            } else if (password.length < 8) {
                strengthMessage.text('Débil').css('color', 'orange');
            } else if (password.match(/[A-Za-z]/) && password.match(/[0-9]/) && password.length >= 8) {
                strengthMessage.text('Fuerte').css('color', 'green');
            } else if (password.match(/[A-Za-z]/) && password.match(/[0-9]/) && password.match(/[^A-Za-z0-9]/)) {
                strengthMessage.text('Muy fuerte').css('color', 'darkgreen');
            } else {
                strengthMessage.text('Débil').css('color', 'orange');
            }
        });

        $('#loginForm').on('submit', function (e) {
            console.log(9823427);
            var password1 = $('#password1').val();
            var password2 = $('#password2').val();
            var confirmPasswordError = $('#confirm-password-error');

            if (password1 !== password2) {
                console.log(987);
                confirmPasswordError.text('Las contraseñas no coinciden');
                e.preventDefault();
            } else {
                confirmPasswordError.text('');
            }
        });
    });
</script>

</body>

</html>
