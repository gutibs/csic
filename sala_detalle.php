<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
include("config/config.php");
include("clases/clase_csic.php");
$of = new Csic();
$of->storeFormValues($_GET);
$sala = $of->traer_sala_detalle();


$sql = "SELECT direccion, codigo_postal FROM edificio WHERE id = " . $sala->edificio_id;
$dir = $of->get_this_1($sql);
$direccion = $dir->direccion . " " . $dir->codigo_postal;
/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gestión de reservas</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="static/imagenes/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="static/imagenes/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="static/imagenes/favicon/favicon-16x16.png">
    <link rel="manifest" href="static/imagenes/favicon/site.webmanifest">

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


    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

</head>

<body class="portfolio-details-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="static/imagenes/<?php echo LOGO_INSTITUCIONAL; ?>" alt="">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php
                if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === 1) {
                    echo '<li><a href="" class="btn_disponibilidad">Ver disponibilidad</a></li>';
                }
                if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === 1) {
                    echo '<li><a href="usuario/index.php">Mis Gestiones</a></li>';
                } else {
                    echo '<li><a href="index.php#ingreso">Ingreso</a></li>';
                }
                if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === 1) {
                    echo '<li><a href="logout.php">Salir</a></li>';
                }
                ?>


            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<main class="main">
    <div class="page-title dark-background">
        <div class="container position-relative">
            <h1><?php echo $sala->nombre_sala; ?></h1>
        </div>
    </div>
    <section id="portfolio-details" class="portfolio-details section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-8">
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
                            if (!is_null($sala->imagen1)) {
                                $carro[] = $sala->imagen1;
                            }
                            if (!is_null($sala->imagen2)) {
                                $carro[] = $sala->imagen2;
                            }
                            if (!is_null($sala->imagen3)) {
                                $carro[] = $sala->imagen3;
                            }
                            if (!is_null($sala->imagen4)) {
                                $carro[] = $sala->imagen4;
                            }
                            if (!is_null($sala->imagen5)) {
                                $carro[] = $sala->imagen5;
                            }
                            // if( !is_null($sala->imagen1)){ $carro[] = $sala->imagen1; }
                            foreach ($carro as $v) {
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
                <div class="col-4">
                    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                        <h3><?php echo $direccion; ?></h3>
                        <ul>
                            <li><strong style="text-decoration:underline">Descripción:</strong></li>
                            <li><strong>Capacidad</strong>: <?php echo $sala->capacidad; ?> personas.</li>
                            <li><strong>Ordenador</strong>: <?php echo ($sala->ordenador === 1) ? "Si" : "No"; ?></li>
                            <li><strong>Video
                                    conferencia</strong>: <?php echo ($sala->videoconferencia === 1) ? "Si" : "No"; ?>
                            </li>
                            <li><strong>Television</strong>: <?php echo ($sala->television === 1) ? "Si" : "No"; ?></li>
                            <li><strong>Proyector</strong>: <?php echo ($sala->proyector === 1) ? "Si" : "No"; ?></li>
                            <li><strong>Catering</strong>: <?php echo ($sala->catering === 1) ? "Si" : "No"; ?></li>
                            <li><strong>Campo
                                    Magnético</strong>: <?php echo ($sala->anillo_magnetico === 1) ? "Si" : "No"; ?>
                            </li>
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
    </section>


    <div class="modal fade" id="modal_solicita_sala" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="solicitarSalaForm" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input name="sala" type="hidden" value="<?php echo $sala->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verticallyCenteredModalLabel">Solicitar Sala</h5>
                        <button class="btn btn-close p-1" type="button" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div id="responseMessage" style="display:none;" class="alert"></div> <!-- Response Message -->
                        <div class="formContent"> <!-- Wrapper for the form fields -->
                            <div class="mb-3">
                                <label for="daterange" class="form-label">Fecha deseada</label>
                                <input type="text" class="form-control" id="daterange" name="nombre_sala" value="">
                            </div>
                            <div class="mb-3">
                                <label for="numero_participantes" class="form-label">Número de Participantes</label>
                                <input type="number" min="1" step="1" class="form-control" id="numero_participantes"
                                       required name="numero_participantes" value="">
                            </div>
                            <div class="mb-3">
                                <label for="comentarios" class="form-label">Comentarios</label>
                                <textarea class="form-control" id="comentarios" name="comentarios" cols="15"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary formContent" type="button" id="submitSolicitud">Solicitar
                        </button>
                        <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>


            </div>

        </div>
    </div>


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

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#daterange').daterangepicker({
            opens: 'right',
            locale: {
                format: 'DD-MM-YYYY', // Updated format
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                fromLabel: "Desde",
                toLabel: "Hasta",
                customRangeLabel: "Personalizado",
                weekLabel: "S",
                daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
                firstDay: 1 // Start the week on Monday
            },
            minDate: moment() // Prevent selecting past dates
        }, function (start, end) {
            console.log("Rango seleccionado: " + start.format('DD-MM-YYYY') + ' a ' + end.format('DD-MM-YYYY'));
        });
    });

    $(".btn_disponibilidad").on('click', function (e) {
        e.preventDefault()
        $("#modal_solicita_sala").modal('show')
    })


    $(document).ready(function () {
        $('#submitSolicitud').on('click', function (e) {
            e.preventDefault();

            const formData = $('#solicitarSalaForm').serialize(); // Serialize form data

            $.ajax({
                url: 'reserva_sala_proceso.php', // PHP handler
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON response
                success: function (response) {
                    const responseDiv = $('#responseMessage');
                    if (response.success) {
                        // Show success message
                        responseDiv
                            .removeClass('alert-danger')
                            .addClass('alert alert-success')
                            .html(response.message)
                            .show();

                        // Hide form content
                        $('.formContent').hide();
                    } else {
                        // Show error message
                        responseDiv
                            .removeClass('alert-success')
                            .addClass('alert alert-danger')
                            .html(response.message)
                            .show();
                    }
                },
                error: function (e) {
                    console.log(e)
                    const responseDiv = $('#responseMessage');
                    responseDiv
                        .removeClass('alert-success')
                        .addClass('alert alert-danger')
                        .html('Ocurrió un error al procesar la solicitud.')
                        .show();
                }
            });


        });

        $('#solicitarSalaForm').closest('.modal').on('hidden.bs.modal', function () {
            // Reset form fields
            $('#solicitarSalaForm')[0].reset();

            // Reset the response message and hide it
            $('#responseMessage').hide().removeClass('alert-success alert-danger').html('');

            // Show the form content again
            $('#formContent').show();
        });
    });


</script>
</body>

</html>
