<?php
session_start();
unset($_SESSION);
session_destroy();
require '../config/config.php';
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
    <link href="../static/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="../static/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="../static/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="../static/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
</head>
<body>
<main class="main" id="top">
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a class="d-flex flex-center text-decoration-none mb-4" href="ingreso.php">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="../static/imagenes/66_CSIC.jpg"  />
                    </div>
                </a>
                <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Gracias, por favor haga el Login</h3>
                    <a href="../ingreso.php">AQUI</a>
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
