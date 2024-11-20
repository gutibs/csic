<?php
session_start();
include("../config/config.php");



if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<head>
    <?php
    include("../administrador/header.php");
    ?>
</head>
<body>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container">
        <div class="row flex-center min-vh-100 py-5">
          <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
              <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="../../../assets/img/icons/logo.png" alt="CSIC" width="58" />
              </div>

            <div class="text-center mb-7">
              <h3 class="text-body-highlight">Ingreso Administradores</h3>
            </div>

<form method="post" action="login.php">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="mb-3 text-start">
              <label class="form-label" for="email">Correo</label>
              <div class="form-icon-container">
                <input class="form-control form-icon-input" name="email" id="email" type="email" placeholder="nombre@ejemplo.com" /><span class="fas fa-user text-body fs-9 form-icon"></span>
              </div>
            </div>
            <div class="mb-3 text-start">
              <label class="form-label" for="password">Password</label>
              <div class="form-icon-container" data-password="data-password">
                <input class="form-control form-icon-input pe-6" name="password" id="password" type="password" placeholder="Password" data-password-input="data-password-input" /><span class="fas fa-key text-body fs-9 form-icon"></span>
                <button class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary" data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span class="uil uil-eye-slash hide"></span></button>
              </div>
            </div>

            <button class="btn btn-primary w-100 mb-3">Ingresar</button>
</form>

          </div>
        </div>
      </div>

    </main>

    <?php
    include("../administrador/footer.php");
    ?>
  </body>

</html>
