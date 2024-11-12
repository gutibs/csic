<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

$sql = "SELECT * FROM unidades WHERE 1 order by nombre";
$sal = $csic->get_this_all($sql);
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
                                <span><h3 class="mb-0">Unidades</h3><small>Click para editar</small></span>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_nueva_unidad">Crear Nueva unidad</button>
                            </div>
                            <?php
                            foreach($sal as $v){
                                echo '<a href="unidad_edita.php?unidad='.$v->id.'" class="text-body-tertiary fw-semibold btn_edita_unidad"  >'.$v->nombre.'</a><br>';
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>




            <div class="modal fade" id="modal_nueva_unidad" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="post" action="acciones/unidad_cambia.php">
                            <input name="accion" type="hidden" value="nueva">
                            <div class="modal-header">
                            <h5 class="modal-title" id="verticallyCenteredModalLabel">Crear Unidad</h5>
                            <button class="btn btn-close p-1" type="button" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <label for="nueva_unidad_nombre">Nombre de la Unidad</label>
                                    <input id="nueva_unidad_nombre" name="nueva_unidad_nombre" required value="" class="form-control" >
                                </div>
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
        $('.btn_edita_unidad').on('click', function(){
            var unidad = $(this).attr('data-id')
            window.location.href = 'unidad_edita.php?unidad='+unidad

        })



    })


    function confirmSubmit(event) {
        event.preventDefault(); // Stop the form from submitting immediately

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas eliminar la unidad?",
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
