<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

?>
<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<head>
    <?php
    include("header.php");
    ?>
</head>
<body>
<main class="main" id="top">
    <div class="container-fluid">
        <?php
        include("navBar.php");
        ?>
        <div class="content">
            <div class="row gy-3 mb-6 justify-content-between">
                <div class="col-md-9 col-auto">
                    <h2 class="mb-2 text-body-emphasis">Panel de Control</h2>
                    <h5 class="text-body-tertiary fw-semibold">Desde aquí administrará las distintas secciones.</h5>
                </div>
            </div>
            <div class="row mb-3 gy-6">
                <?php
                include("barra_informativa.php");
                ?>
            </div>


            <div class="row mb-3 gy-6">
                <div class="col-12">
                    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-6 border-top">
                        <div id="projectSummary"
                             data-list='{"valueNames":["project","assignees","start","deadline","calculation","projectprogress","status","action"],"page":6,"pagination":true}'>
                            <div class="row align-items-end justify-content-between pb-4 g-3">
                                <div class="col-auto">
                                    <h3>Reservas</h3>
                                    <p class="text-body-tertiary lh-sm mb-0">Resumen de las ultimas reservas</p>
                                </div>
                            </div>
                            <div class="table-responsive ms-n1 ps-1 scrollbar">
                                <table class="table fs-9 mb-0 border-top border-translucent">
                                    <thead>
                                    <tr>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="project" style="width:30%;">SALA
                                        </th>
                                        <th class="sort align-middle ps-3" scope="col" data-sort="start"
                                            style="width:10%;">Fecha Inicio
                                        </th>
                                        <th class="sort align-middle ps-3" scope="col" data-sort="deadline"
                                            style="width:15%;">Fecha Fin
                                        </th>
                                        <th class="sort align-middle ps-3" scope="col" data-sort="calculation"
                                            style="width:12%;">Usuario solicitante
                                        </th>
                                        <th class="sort align-middle ps-3" scope="col" data-sort="calculation"
                                            style="width:12%;">Estado de la reserva
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="list" id="project-summary-table-body">
                                    <tr class="position-static">
                                        <td class="align-middle time white-space-nowrap ps-0 project"><a
                                                    class="fw-bold fs-8" href="#">Sala 1</a></td>
                                        <td class="align-middle white-space-nowrap start ps-3">
                                            <p class="mb-0 fs-9 text-body">12-4-2024 10:00</p>
                                        </td>
                                        <td class="align-middle white-space-nowrap deadline ps-3">
                                            <p class="mb-0 fs-9 text-body">12-4-2024 19:00</p>
                                        </td>
                                        <td class="align-middle white-space-nowrap calculation ps-3">
                                            <p class="fw-bold text-body-emphasis fs-9 mb-0">Juan Luis Segura</p>
                                        </td>
                                        <td class="align-middle white-space-nowrap calculation ps-3">
                                            <p class="fw-bold text-body-emphasis fs-9 mb-0">Confirmada</p>
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                              
                                <div class="col-auto d-flex">
                                    <button class="page-link" data-list-pagination="prev"><span
                                                class="fas fa-chevron-left"></span></button>
                                    <ul class="mb-0 pagination"></ul>
                                    <button class="page-link pe-0" data-list-pagination="next"><span
                                                class="fas fa-chevron-right"></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            include("footer_texto.php");
            ?>
        </div>

    </div>

</main>


<?php
include("footer.php");
?>
</body>

</html>
