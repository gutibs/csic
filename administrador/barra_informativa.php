<?php

$sql = "SELECT COUNT(*) as salas FROM salas WHERE unidad_id = ".$_SESSION["unidad"];
$cs = $csic->get_this_1($sql);
$cantidad_salas = $cs->salas;

$sql = "SELECT COUNT(*) as edificios FROM edificio WHERE unidad = ".$_SESSION["unidad"];
$ce = $csic->get_this_1($sql);
$cantidad_edificios = $ce->edificios;


$sql = "SELECT COUNT(*) as reservas FROM reservas WHERE unidad = ".$_SESSION["unidad"];
$re = $csic->get_this_1($sql);
$cantidad_reservas = $re->reservas;


$sql = "SELECT COUNT(*) as usuarios FROM usuarios WHERE unidad = ".$_SESSION["unidad"];
$re = $csic->get_this_1($sql);
$cantidad_usuarios = $re->usuarios;

?>
<div class="col">
    <div class="row align-items-center g-3 g-xxl-0 h-100 align-content-between">

        <div class="col">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-dice-five text-success-dark"></span>
                <div class="ms-2">
                    <div class="d-flex align-items-end">
                        <h2 class="mb-0 me-2"><?php echo $cantidad_salas;?></h2><span class="fs-7 fw-semibold text-body"><a href="salas.php" style="text-decoration:none">Salas</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-building text-warning-dark"></span>
                <div class="ms-2">
                    <div class="d-flex align-items-end">
                        <h2 class="mb-0 me-2"><?php echo $cantidad_edificios; ?></h2><span class="fs-7 fw-semibold text-body"><a href="edificios.php" style="text-decoration:none">Edificios</a></span>
                    </div>

                </div>
            </div>
        </div>

        <div class="col">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-refresh text-danger-dark"></span>
                <div class="ms-2">
                    <div class="d-flex align-items-end">
                        <h2 class="mb-0 me-2"><?php echo $cantidad_reservas; ?></h2><span class="fs-7 fw-semibold text-body"><a href="dashboard.php" style="text-decoration:none">Reservas</a></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-user text-danger-dark"></span>
                <div class="ms-2">
                    <div class="d-flex align-items-end">
                        <h2 class="mb-0 me-2"><?php echo $cantidad_usuarios; ?></h2><span class="fs-7 fw-semibold text-body"><a href="usuarios.php" style="text-decoration:none">Usuarios</a></span>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
