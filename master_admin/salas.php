<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

$sql = "SELECT * FROM salas WHERE 1 ";
$sal = $csic->get_this_all($sql);

$unidades = $csic->traer_unidades();
$edificios = $csic->traer_edificios();

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
                    <a href="dashboard.php"><h2 class="mb-2 text-body-emphasis">Panel de Control</h2></a>
                    <h5 class="text-body-tertiary fw-semibold">Desde aquí administrará las distintas secciones.</h5>
                </div>
            </div>
            <div class="row mb-3 gy-6">
                <?php
                include("barra_informativa.php");
                ?>
            </div>
                <div class="col mt-5">
                    <div class="card border h-100 w-100 overflow-hidden">
                        <div class="card-body px-5 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <span><h3 class="mb-0">Salas</h3><small>Click para editar</small></span>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nueva_unidad">Crear Nueva Sala</button>
                            </div>
                            <?php

                            foreach($sal as $v){
                                echo '<p class="text-body-tertiary fw-semibold btn_edita_sala" style="cursor:pointer" data-id="'.$v->id.'" >'.$v->nombre_sala.'</p>';
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>


            <div class="modal fade" id="modal_nueva_unidad" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="acciones/sala_nueva_graba.php" enctype="multipart/form-data">
                            <input name="accion" type="hidden" value="nueva">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticallyCenteredModalLabel">Crear Sala</h5>
                                <button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data">
                                    <!-- Hidden ID -->
                                    <input type="hidden" name="id" value="1">

                                    <!-- Unidad -->
                                    <div class="mb-3">
                                        <label for="unidad_id" class="form-label">Unidad</label>
                                        <select class="form-select" id="unidad_id" name="unidad_id" required>
                                            <option value=''>Seleccione</option>
                                            <?php
                                            foreach($unidades as $unidad){

                                                echo "<option value='{$unidad->id}'>{$unidad->nombre}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Nombre de la Sala -->
                                    <div class="mb-3">
                                        <label for="nombre_sala" class="form-label">Nombre de la Sala</label>
                                        <input type="text" class="form-control" id="nombre_sala" name="nombre_sala" value="Sala Polivalente">
                                    </div>

                                    <!-- Número de Sala -->
                                    <div class="mb-3">
                                        <label for="numero_sala" class="form-label">Número de Sala</label>
                                        <input type="text" class="form-control" id="numero_sala" name="numero_sala" value="6121">
                                    </div>

                                    <!-- Capacidad -->
                                    <div class="mb-3">
                                        <label for="capacidad" class="form-label">Capacidad</label>
                                        <input type="number" class="form-control" id="capacidad" name="capacidad" value="123">
                                    </div>

                                    <!-- Equipamiento -->
                                    <fieldset class="mb-3">
                                        <legend class="col-form-label pt-0">Equipamiento</legend>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ordenador" name="ordenador" value="1" checked>
                                            <label class="form-check-label" for="ordenador">Ordenador</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="videoconferencia" name="videoconferencia" value="1" checked>
                                            <label class="form-check-label" for="videoconferencia">Videoconferencia</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="television" name="television" value="1" checked>
                                            <label class="form-check-label" for="television">Televisión</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="proyector" name="proyector" value="1" checked>
                                            <label class="form-check-label" for="proyector">Proyector</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="catering" name="catering" value="1" checked>
                                            <label class="form-check-label" for="catering">Catering</label>
                                        </div>
                                    </fieldset>

                                    <!-- Imágenes -->
                                    <div class="mb-3">
                                        <label class="form-label">Imágenes</label>
                                        <div class="mb-2">
                                            <label for="imagen1" class="form-label">Imagen 1</label>
                                            <input class="form-control" type="file" id="imagen1" name="imagen1">
                                        </div>
                                        <!-- Repeat for imagen2 to imagen5 -->
                                        <div class="mb-2">
                                            <label for="imagen2" class="form-label">Imagen 2</label>
                                            <input class="form-control" type="file" id="imagen2" name="imagen2">
                                        </div>
                                        <div class="mb-2">
                                            <label for="imagen3" class="form-label">Imagen 3</label>
                                            <input class="form-control" type="file" id="imagen3" name="imagen3">
                                        </div>
                                        <div class="mb-2">
                                            <label for="imagen4" class="form-label">Imagen 4</label>
                                            <input class="form-control" type="file" id="imagen4" name="imagen4">
                                        </div>
                                        <div class="mb-2">
                                            <label for="imagen5" class="form-label">Imagen 5</label>
                                            <input class="form-control" type="file" id="imagen5" name="imagen5">
                                        </div>
                                    </div>

                                    <!-- Video -->
                                    <div class="mb-3">
                                        <label for="video" class="form-label">Video</label>
                                        <input class="form-control" type="file" id="video" name="video">
                                    </div>

                                    <!-- Manuales -->
                                    <div class="mb-3">
                                        <label class="form-label">Manuales</label>
                                        <div class="mb-2">
                                            <label for="manual_uso" class="form-label">Manual de Uso</label>
                                            <input class="form-control" type="file" id="manual_uso" name="manual_uso">
                                        </div>
                                           <div class="mb-2">
                                            <label for="manual_encendido" class="form-label">Manual de Encendido</label>
                                            <input class="form-control" type="file" id="manual_encendido" name="manual_encendido">
                                        </div>
                                        <div class="mb-2">
                                            <label for="manual_apagado" class="form-label">Manual de Apagado</label>
                                            <input class="form-control" type="file" id="manual_apagado" name="manual_apagado">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edificio_id" class="form-label">Edificio</label>
                                        <select class="form-select" id="edificio_id" name="edificio_id" required>
                                            <option value="" selected>Seleccione</option>
                                            <?php
                                            foreach($edificios as $edificio){

                                                echo "<option value='{$edificio->id}'>{$edificio->nombre}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" type="submit">Grabar</button>
                                <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
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
<script>
    $(document).ready(function(){
        $('.btn_edita_sala').on('click', function(){
            var sala_id  = $(this).attr('data-id')
            window.location.href = 'sala_edita.php?sala_id='+sala_id
        })
    })

</script>
</body>

</html>
