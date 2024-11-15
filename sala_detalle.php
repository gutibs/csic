<?php
include("config/config.php");
include("clases/clase_csic.php");
$of = new Csic();
$of->storeFormValues($_GET);
$sala = $of->traer_sala_detalle();


$sql = "SELECT direccion, codigo_postal FROM edificio WHERE id = ".$sala->edificio_id;
$dir = $of->get_this_1($sql);
$direccion = $dir->direccion." ".$dir->codigo_postal;


$sql = "SELECT id, nombre_sala as nombre FROM salas WHERE 1 ORDER BY nombre";
$cs = $of->get_this_all($sql);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestión de reservas</title>

    <!-- Favicons -->
    <link href="template_sitio/assets/img/favicon.png" rel="icon">
    <link href="template_sitio/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Quicksand:wght@300;400;500;600;700&family=Domine:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="template_sitio/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="template_sitio/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="template_sitio/assets/css/main.css" rel="stylesheet">

</head>

<body class="portfolio-details-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="static/imagenes/66_CSIC.jpg"  alt="" >
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>

<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container position-relative">
            <h1><?php echo $sala->nombre_sala." <small>(".$sala->numero_sala.")</small>";?></h1></div>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-8">
                    <div class="portfolio-details-slider swiper init-swiper">

                        <script type="application/json" class="swiper-config">
                            {
                                "loop": true,
                                "speed": 600,
                                "autoplay": {
                                    "delay": 5000
                                },
                                "slidesPerView": "auto",
                                "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "bullets",
                                    "clickable": true
                                }
                            }
                        </script>

                        <div class="swiper-wrapper align-items-center">
                            <?php
                            if( !is_null($sala->imagen1)){ $carro[] = $sala->imagen1; }
                            if( !is_null($sala->imagen2)){ $carro[] = $sala->imagen2; }
                            if( !is_null($sala->imagen3)){ $carro[] = $sala->imagen3; }
                            if( !is_null($sala->imagen4)){ $carro[] = $sala->imagen4; }
                            if( !is_null($sala->imagen5)){ $carro[] = $sala->imagen5; }
                            // if( !is_null($sala->imagen1)){ $carro[] = $sala->imagen1; }
                            foreach($carro as $v){
                            ?>
                            <div class="swiper-slide">
                                <img src="static/imagenes/salas/<?php echo $v; ?>" height="500vh" alt="">
                            </div>
                            <?php
                            }
                            ?>

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                        <h3><?php echo $direccion; ?></h3>
                        <ul>
                            <li><strong style="text-decoration:underline">Descripción:</strong></li>
                            <li><strong>Capacidad</strong>: <?php echo $sala->capacidad; ?> personas.</li>
                            <li><strong>Ordenador</strong>: <?php echo ($sala->ordenador === 1) ?  "Si" : "No"; ?></li>
                            <li><strong>Video conferencia</strong>: <?php echo ($sala->videoconferencia === 1) ?  "Si" : "No"; ?></li>
                            <li><strong>Television</strong>: <?php echo ($sala->television === 1) ?  "Si" : "No"; ?></li>
                            <li><strong>Proyector</strong>: <?php echo ($sala->proyector === 1) ?  "Si" : "No"; ?></li>
                            <li><strong>Catering</strong>: <?php echo ($sala->catering === 1) ?  "Si" : "No"; ?></li>
                            <li><strong>Anillo Magnético</strong>: <?php echo ($sala->anillo_magnetico === 1) ?  "Si" : "No"; ?></li>
                        </ul>
                    </div>
                    <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                        <!--
                        <h2>Exercitationem repudiandae officiis neque suscipit</h2>
                        <p>
                            Autem ipsum nam porro corporis rerum. Quis eos dolorem eos itaque inventore commodi labore quia quia. Exercitationem repudiandae officiis neque suscipit non officia eaque itaque enim. Voluptatem officia accusantium nesciunt est omnis tempora consectetur dignissimos. Sequi nulla at esse enim cum deserunt eius.
                        </p>
                        -->
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Portfolio Details Section -->

</main>

<footer id="footer" class="footer position-relative dark-background">
    <div class="container">

        <div class="container">
            <div class="copyright">
                <span>Derechos reservados</span><span><?php echo date('Y');?></span>
            </div>
            <div class="credits">
                Desarrollado por <a href="https://www.csic.es">CSIC.es</a>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="template_sitio/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="template_sitio/assets/vendor/php-email-form/validate.js"></script>
<script src="template_sitio/assets/vendor/aos/aos.js"></script>
<script src="template_sitio/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="template_sitio/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="template_sitio/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="template_sitio/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

<!-- Main JS File -->
<script src="template_sitio/assets/js/main.js"></script>

</body>

</html>
