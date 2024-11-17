<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

if (!isset($_GET['sala_id']) || !ctype_digit($_GET['sala_id'])) {
    header("Location: error.php");
    exit;
}

$sala_id = $_GET['sala_id'];

$sql = "SELECT * FROM salas WHERE id = $sala_id";
$sala = $csic->get_this_1($sql);
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
                            <form action="acciones/sala_edita_graba.php" method="post" enctype="multipart/form-data">
                                <!-- Hidden input for ID -->
                                <input type="hidden" name="id" value="<?= htmlspecialchars($sala->id) ?>">

                                <div class="row">
                                    <!-- Unidad ID -->
                                    <div class="col-4 mb-3">
                                        <label for="unidad_id" class="form-label">Unidad</label>
                                        <select class="form-select" id="unidad_id" name="unidad_id" required>
                                            <option value=''>Seleccione</option>
                                            <?php
                                            foreach ($unidades as $unidad) {
                                                if ($sala->unidad_id === $unidad->id) {
                                                    $sel = ' selected ';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo "<option {$sel} value='{$unidad->id}'>{$unidad->nombre}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Nombre Sala -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="nombreSala">Nombre de Sala</label>
                                        <input class="form-control" id="nombreSala" name="nombre_sala" type="text"
                                               value="<?= htmlspecialchars($sala->nombre_sala) ?>">
                                    </div>

                                    <!-- Numero Sala -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="numeroSala">Número de Sala</label>
                                        <input class="form-control" id="numeroSala" name="numero_sala" type="number"
                                               value="<?= htmlspecialchars($sala->numero_sala) ?>">
                                    </div>

                                    <!-- Capacidad -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="capacidad">Capacidad</label>
                                        <input class="form-control" id="capacidad" name="capacidad" type="number"
                                               value="<?= htmlspecialchars($sala->capacidad) ?>">
                                    </div>

                                    <!-- Ordenador -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="ordenador">Ordenador</label>
                                        <select class="form-select" id="ordenador" name="ordenador">
                                            <option value="1" <?= $sala->ordenador == 1 ? 'selected' : '' ?>>Sí</option>
                                            <option value="0" <?= $sala->ordenador == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>

                                    <!-- Videoconferencia -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="videoconferencia">Videoconferencia</label>
                                        <select class="form-select" id="videoconferencia" name="videoconferencia">
                                            <option value="1" <?= $sala->videoconferencia == 1 ? 'selected' : '' ?>>Sí
                                            </option>
                                            <option value="0" <?= $sala->videoconferencia == 0 ? 'selected' : '' ?>>No
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Television -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="television">Televisión</label>
                                        <select class="form-select" id="television" name="television">
                                            <option value="1" <?= $sala->television == 1 ? 'selected' : '' ?>>Sí
                                            </option>
                                            <option value="0" <?= $sala->television == 0 ? 'selected' : '' ?>>No
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Proyector -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="proyector">Proyector</label>
                                        <select class="form-select" id="proyector" name="proyector">
                                            <option value="1" <?= $sala->proyector == 1 ? 'selected' : '' ?>>Sí</option>
                                            <option value="0" <?= $sala->proyector == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>

                                    <!-- Catering -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="catering">Catering</label>
                                        <select class="form-select" id="catering" name="catering">
                                            <option value="1" <?= $sala->catering == 1 ? 'selected' : '' ?>>Sí</option>
                                            <option value="0" <?= $sala->catering == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="anillo_magnetico">Campo magnetico</label>
                                        <select class="form-select" id="anillo_magnetico" name="anillo_magnetico">
                                            <option value="1" <?= $sala->anillo_magnetico == 1 ? 'selected' : '' ?>>Sí
                                            </option>
                                            <option value="0" <?= $sala->anillo_magnetico == 0 ? 'selected' : '' ?>>No
                                            </option>
                                        </select>
                                    </div>


                                    <!-- Incidencia -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="incidencia">Incidencia</label>
                                        <input class="form-control" id="incidencia" name="incidencia" type="text"
                                               value="<?= htmlspecialchars($sala->incidencia) ?>">
                                    </div>

                                    <!-- Tipo Incidencia -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="tipoIncidencia">Tipo de Incidencia</label>
                                        <input class="form-control" id="tipoIncidencia" name="tipo_incidencia"
                                               type="text" value="<?= htmlspecialchars($sala->tipo_incidencia) ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Imagen 1 -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="imagen1">Imagen 1</label>
                                        <input class="form-control" id="imagen1" name="imagen1" type="file">
                                        <small>Actual:</small>
                                        <?php if (!empty($sala->imagen1)): ?>
                                            <div class="mt-2">
                                                <img src="../static/imagenes/salas/<?= htmlspecialchars($sala->imagen1) ?>"
                                                     alt="Current Image"
                                                     style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                                            </div>
                                        <?php else: ?>
                                            <small>No hay imagen</small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Imagen 2 -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="imagen2">Imagen 2</label>
                                        <input class="form-control" id="imagen2" name="imagen2" type="file">
                                        <small>Actual:</small>
                                        <?php if (!empty($sala->imagen2)): ?>
                                            <div class="mt-2">
                                                <img src="../static/imagenes/salas/<?= htmlspecialchars($sala->imagen2) ?>"
                                                     alt="Current Image"
                                                     style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                                            </div>
                                        <?php else: ?>
                                            <small>No hay imagen</small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Imagen 3 -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="imagen3">Imagen 3</label>
                                        <input class="form-control" id="imagen3" name="imagen3" type="file">
                                        <small>Actual:</small>
                                        <?php if (!empty($sala->imagen3)): ?>
                                            <div class="mt-2">
                                                <img src="../static/imagenes/salas/<?= htmlspecialchars($sala->imagen3) ?>"
                                                     alt="Current Image"
                                                     style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                                            </div>
                                        <?php else: ?>
                                            <small>No hay imagen</small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Imagen 4 -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="imagen1">Imagen 4</label>
                                        <input class="form-control" id="imagen4" name="imagen4" type="file">
                                        <small>Actual:</small>
                                        <?php if (!empty($sala->imagen4)): ?>
                                            <div class="mt-2">
                                                <img src="../static/imagenes/salas/<?= htmlspecialchars($sala->imagen4) ?>"
                                                     alt="Current Image"
                                                     style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                                            </div>
                                        <?php else: ?>
                                            <small>No hay imagen</small>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Imagen 1 -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="imagen5">Imagen 5</label>
                                        <input class="form-control" id="imagen5" name="imagen5" type="file">
                                        <small>Actual:</small>
                                        <?php if (!empty($sala->imagen5)): ?>
                                            <div class="mt-2">
                                                <img src="../static/imagenes/salas/<?= htmlspecialchars($sala->imagen5) ?>"
                                                     alt="Current Image"
                                                     style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                                            </div>
                                        <?php else: ?>
                                            <small>No hay imagen</small>
                                        <?php endif; ?>
                                    </div>


                                    <!-- Video -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="video">Video</label>
                                        <input class="form-control" id="video" name="video" type="file">
                                        <small>Actual: <?= htmlspecialchars($sala->video) ?></small>
                                    </div>

                                </div>
                                <div class="row">
                                    <!-- Manuales -->


                                    <div class="col-4 mb-2">
                                        <label for="manual_uso" class="form-label">Manual de Uso</label>
                                        <input class="form-control" type="file" id="manual_uso" name="manual_uso">
                                        <small>Actual: <?= htmlspecialchars($sala->manual_uso) ?></small>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label for="manual_encendido" class="form-label">Manual de Encendido</label>
                                        <input class="form-control" type="file" id="manual_encendido"
                                               name="manual_encendido">
                                        <small>Actual: <?= htmlspecialchars($sala->manual_encendido) ?></small>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <label for="manual_apagado" class="form-label">Manual de Apagado</label>
                                        <input class="form-control" type="file" id="manual_apagado"
                                               name="manual_apagado">
                                        <small>Actual: <?= htmlspecialchars($sala->manual_apagado) ?></small>
                                    </div>

                                </div>
                                <div class="row">
                                    <!-- Edificio ID -->
                                    <div class="col-4 mb-3">
                                        <label for="edificio_id">Edificio</label>
                                        <select class="form-select" id="edificio_id" name="edificio_id" required>
                                            <option value="" selected>Seleccione</option>
                                            <?php
                                            foreach ($edificios as $edificio) {
                                                if ($sala->edificio_id === $edificio->id) {
                                                    $sel = ' selected ';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo "<option {$sel} value='{$edificio->id}'>{$edificio->nombre}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Grabar</button>
                                </div>
                            </form>

                        </div>

                        <div class="row mt-5">
                            <div class="col text-end">
                                <button class="btn btn-danger" role="button" type="button" id="btn_elimina_sala" data-sala="<?php echo $sala->id; ?>">Eliminar</button>
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
<script>
    document.getElementById('btn_elimina_sala').addEventListener('click', function () {
        var salaId = this.getAttribute('data-sala');

        // Trigger SweetAlert2 confirmation
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará las reservas para la misma.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'acciones/sala_cambia.php?accion=elimina&sala=' + salaId;
            }
        });
    });
</script>
</body>

</html>
