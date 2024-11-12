<?php
include("config/config.php");
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>
<!DOCTYPE html>
<html lang="es" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo SITIO_NOMBRE ; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
        <link href="static/vendors/simplebar/simplebar.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
        <link href="static/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
        <link href="static/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
        <link href="static/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
</head>
<body>
<main class="main" id="top">
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a class="d-flex flex-center text-decoration-none mb-4" href="ingreso.php">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="static/imagenes/66_CSIC.jpg"  />
                    </div>
                </a>
                <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Ingreso</h3>
                </div>
                <form id="loginForm" action="login.php" method="POST">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3 text-start form-group" id="email-group">
                        <label class="form-label" for="email">Correo Electrónico</label>
                        <div class="form-icon-container">
                            <input class="form-control form-icon-input" id="email" name="email" type="email" placeholder="nombre@ejemplo.com" required />
                            <span class="fas fa-user text-body fs-9 form-icon"></span>
                        </div>
                        <span class="error-message text-danger" id="email-error"></span>
                    </div>

                    <div class="mb-3 text-start form-group" id="password-group">
                        <label class="form-label" for="password">Clave</label>
                        <div class="form-icon-container position-relative" data-password="data-password">
                            <input class="form-control form-icon-input pe-6" id="password" name="password" type="password" placeholder="Clave" data-password-input="data-password-input" required />
                            <span class="fas fa-key text-body fs-9 form-icon"></span>
                            <button type="button" class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary" data-password-toggle="data-password-toggle">
                                <span class="uil uil-eye show"></span>
                                <span class="uil uil-eye-slash hide"></span>
                            </button>
                        </div>
                        <span class="error-message text-danger" id="password-error"></span>
                    </div>

                    <div class="row flex-between-center mb-7">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" id="basic-checkbox" name="remember_me" type="checkbox" checked="checked" />
                                <label class="form-check-label mb-0" for="basic-checkbox">Recordarme</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3" id="btn_ingreso">Ingresar</button>
                </form>

            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="static/vendors/popper/popper.min.js"></script>
<script src="static/vendors/bootstrap/bootstrap.min.js"></script>
<script src="static/vendors/anchorjs/anchor.min.js"></script>
<script src="static/vendors/is/is.min.js"></script>
<script src="static/vendors/fontawesome/all.min.js"></script>
<script src="static/vendors/lodash/lodash.min.js"></script>
<script src="static/vendors/list.js/list.min.js"></script>
<script src="static/vendors/feather-icons/feather.min.js"></script>
<script src="static/vendors/dayjs/dayjs.min.js"></script>

<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            // Clear previous error messages and classes
            $('.error-message').text('');
            $('.form-group').removeClass('has-error');

            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            var isValid = true;

            // Validate email
            if (email === '') {
                $('#email-error').text('Por favor, ingrese su correo electrónico.');
                $('#email-group').addClass('has-error');
                isValid = false;
            } else if (!validateEmail(email)) {
                $('#email-error').text('Por favor, ingrese un correo electrónico válido.');
                $('#email-group').addClass('has-error');
                isValid = false;
            }

            // Validate password
            if (password === '') {
                $('#password-error').text('Por favor, ingrese su clave.');
                $('#password-group').addClass('has-error');
                isValid = false;
            } else if (password.length < 8) {
                $('#password-error').text('La clave debe tener al menos 8 caracteres.');
                $('#password-group').addClass('has-error');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission
            }
        });

        function validateEmail(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // Toggle password visibility
        $('[data-password-toggle]').on('click', function() {
            var passwordInput = $('#password');
            var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('.uil').toggleClass('show hide');
        });
    });
</script>

</body>

</html>