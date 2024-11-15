<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include("config/config.php");
include("clases/clase_csic.php");
$csic = new Csic();

$departamentos = $csic->traer_departamentos_csic();
$unidades = $csic->traer_unidades_csic();
$servicios = $csic->traer_servicios_csic();
$secciones = $csic->traer_secciones_csic();
?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Phoenix</title>



    <meta name="theme-color" content="#ffffff">
    <script src="template/public/vendors/simplebar/simplebar.min.js"></script>
    <script src="template/public/assets/js/config.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="template/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="template/public/assets/css/theme-rtl.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="template/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="template/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="template/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <div class="container">
        <div class="row flex-center min-vh-100 py-5">
            <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a class="d-flex flex-center text-decoration-none mb-4" href=".index.php">
                    <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="static/imagenes/66_CSIC.jpg" alt="CSIC"  />
                    </div>
                </a>
                <div class="text-center mb-7">
                    <h3 class="text-body-highlight">Registro</h3>
                    <p class="text-body-tertiary">Cree su cuenta para poder reservar salas.</p>
                </div>

                <form method="post" action="registro_do.php">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <div class="mb-3 text-start">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input class="form-control" id="nombre" type="text" placeholder="Nombre" name="nombre" />
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="apellidos">Apellidos</label>
                        <input class="form-control" id="apellidos" type="text" placeholder="apellidos" name="apellidos" />
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="dni">DNI</label>
                        <input class="form-control" id="dni" type="text" placeholder="dni" name="dni" />
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="email">Correo</label>
                        <input class="form-control" id="email" type="email" placeholder="nombre@ejemplo.com" name="email" />
                    </div>
                    <div class="mb-3 text-start">
                        <label class="form-label" for="celular">Teléfono móvil</label>
                        <input class="form-control" id="celular" type="text" name="celular"  name="celular"/>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="password">Password</label>
                            <div class="position-relative" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="password" name="password" type="password" placeholder="Password" data-password-input="data-password-input" />
                                <button type="button" role="button" class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary" data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span class="uil uil-eye-slash hide"></span></button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="confirmPassword">Confirmar Password</label>
                            <div class="position-relative" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="confirmPassword" name="password2"  type="password" placeholder="Confirm Password" data-password-input="data-password-input" />
                                <button type="button" role="button" class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary" data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span class="uil uil-eye-slash hide"></span></button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label" for="usuario_csic">Eres parte del CSIC?</label>
                        <select id="usuario_csic" name="usuario_csic" required class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>


                    <div id="usuario_csic_campos_div" style="display: none">
                        <div class="mb-3 text-start">
                            <label class="form-label" for="departamento">Departamento</label>
                            <select id="departamento" name="departamento" required class="form-select">
                                <option value="">Seleccione</option>
                                <?php
                                foreach($departamentos as $departamento){
                                    echo "<option value='{$departamento->id}'>{$departamento->nombre}</option>'";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="unidad">Unidad</label>
                            <select id="unidad" name="unidad" required class="form-select">
                                <option value="">Seleccione</option>
                                <?php
                                foreach($unidades as $unidad){
                                    echo "<option value='{$unidad->id}'>{$unidad->nombre}</option>'";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="servicio">Servicio</label>
                            <select id="servicio" name="servicio" required class="form-select">
                                <option value="">Seleccione</option>
                                <?php
                                foreach($servicios as $servicio){
                                    echo "<option value='{$servicio->id}'>{$servicio->nombre}</option>'";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="seccion">Sección</label>
                            <select id="seccion" name="seccion" required class="form-select">
                                <option value="">Seleccione</option>
                                <?php
                                foreach($secciones as $seccion){
                                    echo "<option value='{$seccion->id}'>{$seccion->nombre}</option>'";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="direccion_edificio">Dirección del edificio al que pertenece</label>
                            <input class="form-control" id="direccion_edificio" type="text" name="direccion_edificio" />
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="planta">planta</label>
                            <input class="form-control" id="planta" type="text" name="planta" />
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="numero_despacho">Número del despacho</label>
                            <input class="form-control" id="numero_despacho" type="text" name="numero_despacho" />
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="codigo_postal_trabajo">Código postal</label>
                            <input class="form-control" id="codigo_postal_trabajo" type="text" name="codigo_postal_trabajo" />
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label" for="telefono_fijo">Teléfono fijo de contacto</label>
                            <input class="form-control" id="telefono_fijo" type="text" name="telefono_fijo" />
                        </div>

                    </div>
                    <!--

Teléfono fijo de contacto,
Teléfono móvil,

-->
                    <button class="btn btn-primary w-100 mb-3">Registrarme</button>
                    <div class="text-center"><a class="fs-9 fw-bold" href="index.php#ingreso">Ya tengo cuenta</a></div>
                </form>

            </div>
        </div>
    </div>
    <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
            navbarTop.setAttribute('data-navbar-appearance', 'darker');
        }

        var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
        var navbarVertical = document.querySelector('.navbar-vertical');
        if (navbarVertical && navbarVerticalStyle === 'darker') {
            navbarVertical.setAttribute('data-navbar-appearance', 'darker');
        }
    </script>

</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->




<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="template/public/vendors/popper/popper.min.js"></script>
<script src="template/public/vendors/bootstrap/bootstrap.min.js"></script>
<script src="template/public/vendors/anchorjs/anchor.min.js"></script>
<script src="template/public/vendors/is/is.min.js"></script>
<script src="template/public/vendors/fontawesome/all.min.js"></script>
<script src="template/public/vendors/lodash/lodash.min.js"></script>
<script src="template/public/vendors/list.js/list.min.js"></script>
<script src="template/public/vendors/feather-icons/feather.min.js"></script>
<script src="template/public/vendors/dayjs/dayjs.min.js"></script>
<script src="template/public/assets/js/phoenix.js"></script>
<script>
    $(document).ready(function(){
        $("#usuario_csic").on('change', function(){
            var es_usuario = $(this).val()
            if(parseInt(es_usuario) === 1){
                $("#usuario_csic_campos_div").css('display', 'block')
            } else {
                $("#usuario_csic_campos_div").css('display', 'none')
            }
        })
    })
</script>
</body>

</html>