<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

$sql = "SELECT * FROM edificio WHERE 1 order by nombre";
$edi = $csic->get_this_all($sql);

$unidades = $csic->traer_unidades();
$unidad_id = $_SESSION['unidad'];
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

            <div class="col">
                <div class="card border h-100 w-100 overflow-hidden">
                    <div class="card-body px-5 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <span><h3 class="mb-0">Edificios</h3><small>Click para editar</small></span>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nuevo_edificio">Crear Nuevo Edificio</button>
                        </div>
                        <?php
                        foreach($edi as $v){
                            echo '<p class="text-body-tertiary fw-semibold btn_edita_edificio" style="cursor:pointer" data-id="'.$v->id.'" 
                                                                                                                    data-nombre="'.$v->nombre.'"
                                                                                                                    data-direccion="'.$v->direccion.'"
                                                                                                                    data-cp="'.$v->codigo_postal.'"
                                                                                                                    data-unidad="'.$v->unidad.'">'.$v->nombre.'</p>';
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>





        <div class="modal fade" id="modal_edita_edificio" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verticallyCenteredModalLabel">Editar Edificio</h5>
                        <button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="acciones/edificio_cambia.php">
                            <input name="accion" type="hidden" value="edito">
                            <input type="hidden" id="edificio_id" name="id" value="">
                            <input type="hidden" id="unidad_id" name="unidad_id" value="<?php echo $unidad_id; ?>">

                            <div class="col mb-3">
                                <label class="form-label" for="edificio_nombre">Nombre</label>
                                <input id="edificio_nombre" value="" name="nombre" required class="form-control" >
                            </div>
                            <div class="col mb-3">
                                <label class="form-label" for="edificio_nombre">Direccion</label>
                                <input id="edificio_direccion" value="" name="direccion" required class="form-control" >
                            </div>
                            <div class="col mb-3">
                                <label class="form-label" for="edificio_cp">Codigo Postal</label>
                                <input id="edificio_cp" value="" name="codigo_postal" class="form-control" >
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Cambiar</button>
                        </form>
                        <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <form id="myForm" action="acciones/edificio_cambia.php" method="post" onsubmit="return confirmSubmit(event)">
                            <input type="hidden" id="edificio_id_elimina" name="id" value="">
                            <input type="hidden" name="accion" value="elimina">
                            <button class="btn btn-danger" type="submit" id="btn_elimina_edificio" >Eliminar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_nuevo_edificio" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="acciones/edificio_cambia.php">
                        <input name="accion" type="hidden" value="nuevo">
                        <input type="hidden" id="unidad_id" name="unidad_id" value="<?php echo $unidad_id; ?>">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verticallyCenteredModalLabel">Crear Edificio</h5>
                            <button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">

                            <div class="col mb-3">
                                <label class="form-label" for="edificio_nombre">Nombre</label>
                                <input id="edificio_nombre" value="" name="nombre" required class="form-control" >
                            </div>
                            <div class="col mb-3">
                                <label class="form-label" for="edificio_nombre">Direccion</label>
                                <input id="edificio_direccion" value="" name="direccion" required class="form-control" >
                            </div>
                            <div class="col mb-3">
                                <label class="form-label" for="edificio_cp">Codigo Postal</label>
                                <input id="edificio_cp" value="" name="codigo_postal" class="form-control" >
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
        $('.btn_edita_edificio').on('click', function(){
            $("#edificio_nombre").val($(this).attr('data-nombre'))
            $("#edificio_id").val($(this).attr('data-id'))
            $("#edificio_id_elimina").val($(this).attr('data-id'))
            $("#edificio_cp").val($(this).attr('data-cp'))
            $("#edificio_direccion").val($(this).attr('data-direccion'))
            var unidad = $(this).attr('data-unidad')

            $("#unidad_id_edita").val(unidad)

            $('#modal_edita_edificio').modal('show')
        })


        $("#btn_confirma_cambio").on("click", function(){

        })
    })


    function confirmSubmit(event) {
        event.preventDefault(); // Stop the form from submitting immediately

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esto eliminará las salas y reservas para el edificio también.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'No, cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                event.target.submit();
            } else {

            }
        });

        return false; // Prevent the form from submitting before the user responds
    }

</script>
</body>

</html>
