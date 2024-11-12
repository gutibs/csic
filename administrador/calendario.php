<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

$sql = "SELECT * FROM salas WHERE 1 ";
$sal = $csic->get_this_all($sql);


$edificios = $csic->traer_edificios();
$unidad_id = $_SESSION['unidad'];

?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<head>
    <?php
    include("header.php");
    ?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

</head>
<body>
<main class="main" id="top">
    <div class="container-fluid">
        <?php
        include("navBar.php");
        ?>
        <div class="content">
            <div class="row gy-3 mb-6 justify-content-between">
                <div class="col col-auto">
                    <a href="dashboard.php"><h2 class="mb-2 text-body-emphasis">Panel de Control</h2></a>
                    <h5 class="text-body-tertiary fw-semibold">Desde aquí administrará las distintas secciones.</h5>
                </div>
            </div>
            <div class="row mb-3 gy-6">
                <?php
                include("barra_informativa.php");
                ?>
            </div>
            <div class="row mb-3 gy-6">
                <div class="card border ">
                    <div class="card-body px-5 position-relative">
                        <div class="col">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_nueva_reserva" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Modal Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        This is the content of the modal.
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
    include("footer_texto.php");
    ?>
    </div>

</main>


<?php
include("footer.php");
?>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        function myCustomFunction() {
            $("#modal_nueva_reserva").modal('show')
        }

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next customButton', // Add the custom button here
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            customButtons: {
                customButton: {
                    text: 'Nueva Reserva', // Text for the custom button
                    click: myCustomFunction // The function to execute on click
                }
            }
        });
        calendar.render();
    });

</script>
</body>

</html>
