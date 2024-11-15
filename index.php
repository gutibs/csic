<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include("config/config.php");
include("clases/clase_csic.php");
$csic = new Csic();
$ima = "SELECT imagen1, imagen2, imagen3, imagen4, imagen5 FROM salas WHERE imagen1 IS NOT NULL OR imagen2 IS NOT NULL OR imagen3 IS NOT NULL OR imagen4 IS NOT NULL OR imagen5 IS NOT NULL   ORDER BY RAND()";
$ci = $csic->get_this_all($ima);

foreach ($ci as $v) {
    if (!is_null($v->imagen1)) {
        $carro[] = $v->imagen1;
    }
    if (!is_null($v->imagen2)) {
        $carro[] = $v->imagen2;
    }
    if (!is_null($v->imagen3)) {
        $carro[] = $v->imagen3;
    }
    if (!is_null($v->imagen4)) {
        $carro[] = $v->imagen4;
    }
    if (!is_null($v->imagen5)) {
        $carro[] = $v->imagen5;
    }
}
if($carro) {
    shuffle($carro);


$carro = array_slice($carro, 0, 10);
$randomKey = array_rand($carro);
$randomValue = $carro[$randomKey];
}


$sql = "SELECT id, nombre_sala as nombre FROM salas WHERE 1 ORDER BY nombre_sala";
$cs = $csic->get_this_all($sql);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Central de Reservas.</title>

    <!-- Favicons -->
    <link href="template_sitio/img/favicon.png" rel="icon">
    <link href="template_sitio/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Quicksand:wght@300;400;500;600;700&family=Domine:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="template_sitio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="template_sitio/assets/css/main.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .custom-center {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .custom-center h2, .custom-center span {
            width: 100%;
            text-align: center;
            margin: 0;
        }
        .accordion-button {
            background-color: inherit !important;
            color: inherit !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: inherit !important;
            color: inherit !important;
            box-shadow: none; /* Optional: remove the box shadow when active */
        }
    </style>
</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="static/imagenes/66_CSIC.jpg" alt="">

        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#hero" class="active">Inicio</a></li>
                <li><a href="#portfolio">Salas</a></li>
                <li><a href="#ingreso">Solicitud</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>


    </div>
</header>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <img src="static/imagenes/salas/<?php echo $randomValue; ?>" alt="" data-aos="fade-in">

        <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
            <h2>Gestión de reserva de salas.</h2>
            <a href="#portfolio" class="btn-scroll" title="Scroll Down"><i class="bi bi-chevron-down"></i></a>
        </div>

    </section><!-- /Hero Section -->


    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">Las Salas</span>
            <h2>Las Salas</h2>
            <p>Algunas imagenes de las salas disponibles</p>
        </div><!-- End Section Title -->

        <div class="accordion" id="accordionExample">
            <?php
            $sql = "SELECT * FROM unidades WHERE 1 ORDER BY nombre";
            $cs = $csic->get_this_all($sql);
            foreach ($cs as $c => $v){

            // saco las imagenes
            $ima = "SELECT id, imagen1, imagen2, imagen3, imagen4, imagen5 FROM salas WHERE unidad_id = $v->id";
            $ci = $csic->get_this_all($ima);

            if ($c === 0){
            $show = '  ';
            ?>
            <div class="accordion-item border-top">
                <h2 class="accordion-header" id="heading<?php echo $c; ?>>">
                    <?php
                    } else {
                    $show = '  ';
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $c; ?>">
                            <?php
                            }
                            ?>
                            <button class="accordion-button text-center custom-center" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?php echo $c; ?>" aria-expanded="true"
                                    aria-controls="collapse<?php echo $c; ?>">
                                <span class="text-center w-100"><h3><?php echo $v->nombre; ?></h3></span>
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse <?php echo $show; ?>>" id="collapse<?php echo $c; ?>"
                             aria-labelledby="heading<?php echo $c; ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body pt-0">
                                <div class="row mt-3">
                                <?php
                                foreach($ci as $cada => $sala){
                                    if(!is_null($sala->imagen1)){
                                    ?>

                                <div class="col-3 ">
                                <div class="portfolio-content ">
                                    <img src="static/imagenes/salas/<?php echo $sala->imagen1; ?>"
                                         class="img-fluid" alt="">
                                    <div class="portfolio-info">
                                        <a href="static/imagenes/salas/<?php echo $sala->imagen1; ?>"
                                           data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                                    class="bi bi-zoom-in"></i></a>
                                        <a href="sala_detalle.php?sala_id=<?php echo $sala->id; ?>" title="Ver"
                                           class="details-link"><i class="bi bi-link-45deg"></i></a>
                                    </div>
                                </div>
                                </div>
                                        <?php
                                    }
                                if(!is_null($sala->imagen2)){
                                        ?>
                                <div class="col-3">
                                    <div class="portfolio-content ">
                                        <img src="static/imagenes/salas/<?php echo $sala->imagen2; ?>"
                                             class="img-fluid" alt="">
                                        <div class="portfolio-info">
                                            <a href="static/imagenes/salas/<?php echo $sala->imagen2; ?>"
                                               data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                                        class="bi bi-zoom-in"></i></a>
                                            <a href="sala_detalle.php?sala_id=<?php echo $sala->id; ?>" title="Ver"
                                               class="details-link"><i class="bi bi-link-45deg"></i></a>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                }
                                if(!is_null($sala->imagen3)){
                                    ?>
                                <div class="col-3">
                                    <div class="portfolio-content ">
                                        <img src="static/imagenes/salas/<?php echo $sala->imagen3; ?>"
                                             class="img-fluid" alt="">
                                        <div class="portfolio-info">
                                            <a href="static/imagenes/salas/<?php echo $sala->imagen3; ?>"
                                               data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                                        class="bi bi-zoom-in"></i></a>
                                            <a href="sala_detalle.php?sala_id=<?php echo $sala->id; ?>" title="Ver"
                                               class="details-link"><i class="bi bi-link-45deg"></i></a>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                }
                                if(!is_null($sala->imagen4)){
                                    ?>
                                <div class="col-3">
                                    <div class="portfolio-content ">
                                        <img src="static/imagenes/salas/<?php echo $sala->imagen4; ?>"
                                             class="img-fluid" alt="">
                                        <div class="portfolio-info">
                                            <a href="static/imagenes/salas/<?php echo $sala->imagen4; ?>"
                                               data-gallery="portfolio-gallery-book" class="glightbox preview-link"><i
                                                        class="bi bi-zoom-in"></i></a>
                                            <a href="sala_detalle.php?sala_id=<?php echo $sala->id; ?>" title="Ver"
                                               class="details-link"><i class="bi bi-link-45deg"></i></a>
                                        </div>
                                    </div>
                                </div>


                                <?php
                                }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
            </div>




    </section><!-- /Portfolio Section -->


    <!-- Ingreso Section -->
    <section id="ingreso" class="contact section">



            <div class="row">
                <div class="col-3">
                    &nbsp;
                </div>
                <div class="col-6 ">
                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <span class="description-title">Ingresar</span>
                        <h2>Ingresar</h2>
                        <p>Si ya tiene un usuario creado.</p>
                        <p>Ó haz click <a href="registro.php">Aquí</a> para generar un usuario </p>
                    </div><!-- End Section Title -->
                    <div class="container" data-aos="fade-up" data-aos-delay="100">

                        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                            <form id="loginForm" action="login.php" method="POST">
                                <!-- CSRF Token -->
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <div class="mb-3 text-start form-group" id="email-group">
                                    <label class="form-label" for="email">Correo Electrónico</label>
                                    <div class="form-icon-container">
                                        <input class="form-control form-icon-input" id="email" name="email" type="email"
                                               placeholder="nombre@ejemplo.com" required/>
                                        <span class="fas fa-user text-body fs-9 form-icon"></span>
                                    </div>
                                    <span class="error-message text-danger" id="email-error"></span>
                                </div>

                                <div class="mb-3 text-start form-group" id="password-group">
                                    <label class="form-label" for="password">Clave</label>
                                    <div class="form-icon-container position-relative" data-password="data-password">
                                        <input class="form-control form-icon-input pe-6" id="password" name="password"
                                               type="password" placeholder="Clave" data-password-input="data-password-input"
                                               required/>
                                        <span class="fas fa-key text-body fs-9 form-icon"></span>
                                        <button type="button"
                                                class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                                data-password-toggle="data-password-toggle">
                                            <span class="uil uil-eye show"></span>
                                            <span class="uil uil-eye-slash hide"></span>
                                        </button>
                                    </div>
                                    <span class="error-message text-danger" id="password-error"></span>
                                </div>


                                <button type="submit" class="btn btn-primary w-100 mb-3" id="btn_ingreso">Ingresar</button>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5" style="height:75px">&nbsp;</div>
                </div>
            </div>




    </section><!-- /Portfolio Section -->


    <!-- Contact Section -->
    <section id="contacto" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span class="description-title">Contacto</span>
            <h2>Contacto</h2>
            <p>Déjenos un mensaje indicando la sala que desea reservar y la fecha</p>
            <small>Si no tiene una cuenta creada, recibirá un mail de bienvenida apenas procesemos su solicitud y
                podamos darle una respuesta.</small>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <form action="contacto/solicitud.php" method="post" class="php-email-form" data-aos="fade-up"
                  data-aos-delay="300">
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="text" name="nombre_completo" style="display: none;">
                <div class="row gy-4 mt-2">
                    <div class="col-md-6">
                        <input type="text" name="nombre" class="form-control" placeholder="Su nombre" required="">
                    </div>
                    <div class="col-md-6 ">
                        <input type="email" class="form-control" name="email" placeholder="Su Email" required="">
                    </div>
                </div>
                <div class="row gy-4 mt-2">
                    <div class="col-md-6">
                        <label class="form-label" for="datetimepicker">Desde</label>
                        <input class="form-control datetimepicker" id="datetimepicker" type="text"
                               placeholder="dd/mm/yyyy hour : minute"
                               data-options='{"enableTime":true,"dateFormat":"d/m/y H:i","disableMobile":true}'/>
                    </div>
                    <div class="col-md-6 ">
                        <input type="email" class="form-control" name="email" placeholder="Su Email" required="">
                    </div>
                </div>
                <div class="row gy-4 mt-2">
                    <div class="col-md-12">
                        <select class="form-select" name="sala" required>
                            <option value="">Seleccione Sala</option>
                            <?php
                            foreach ($cs as $s) {
                                echo "<option value='{$s->id}'>{$s->nombre}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row gy-4 mt-2">
                    <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Message"
                                  required=""></textarea>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="submit">Enviar petición</button>
                    </div>
                </div>
            </form><!-- End Contact Form -->

        </div>

    </section><!-- /Contact Section -->

</main>

<footer id="footer" class="footer position-relative dark-background">
    <div class="container">

        <div class="container">
            <div class="copyright">
                <span>Derechos reservados</span><span><?php echo date('Y'); ?></span>
            </div>
            <div class="credits">
                Desarrollado por <a href="https://www.csic.es">CSIC.es</a>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script src="template_sitio/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="template_sitio/assets/vendor/aos/aos.js"></script>
<script src="template_sitio/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="template_sitio/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="template_sitio/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="template_sitio/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

<!-- Main JS File -->
<script src="template_sitio/assets/js/main.js"></script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>


<script>
    $(".datetimepicker").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        "locale": "es"
    });
</script>
</body>

</html>
