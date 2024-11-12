<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

if (!isset($_GET['unidad']) || !ctype_digit($_GET['unidad'])) {
    header("Location: error.php");
    exit;
}

$unidad_id = $_GET['unidad'];

$sql = "SELECT * FROM unidades WHERE id = $unidad_id";
$unidad = $csic->get_this_1($sql);

$sql = "SELECT id, email, nombre, apellido, activo FROM usuarios WHERE unidad = $unidad_id AND rol = 2";
$usuarios = $csic->get_this_all($sql);


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

                        <form action="acciones/unidad_cambia.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($unidad_id) ?>">
                            <input type="hidden" name="accion" value="edita">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label" for="nombre">Nombre de Sala</label>
                                    <input class="form-control" id="nombre" name="nombre" type="text"
                                           value="<?= htmlspecialchars($unidad->nombre) ?>">
                                </div>
                                <div class="col-3 mb-3 align-self-end">
                                    <button type="submit" class="btn btn-primary">Cambiar</button>
                                </div>
                            </div>
                        </form>

                        <div class="row mt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th colspan="4">Administradores de la Unidad</th>
                                            <th>
                                                <button class="btn btn-success" id="btn_nuevo_admin"
                                                        data-bs-toggle="modal" data-bs-target="#modal_nuevo_admin">
                                                    Agregar Administrador
                                                </button>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($usuarios as $v) {
                                            $estado = $v->activo === 1 ? 'Activo' : 'Inactivo';
                                            echo '<tr>
                                            <td>' . $v->email . '</td>
                                            <td>' . $v->nombre . '</td>
                                            <td>' . $v->apellido . '</td>
                                            <td>' . $estado . '</td>
                                            <td><a class="btn btn-secondary" href="usuario_edita.php?usuario=' . $v->id . '">Editar</a> </td>
                                        </tr>';
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col justify-content-end">
                                <button class="btn btn-danger" role="button" type="button" id="btn_elimina_unidad" data-unidad="<?php echo $unidad_id; ?>">Eliminar</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="modal fade" id="modal_nuevo_admin" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verticallyCenteredModalLabel">Agregar Administrador</h5>
                            <button class="btn btn-close p-1" type="button" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="acciones/nuevo_admin.php">
                                <input type="hidden" value="<?php echo $unidad_id; ?>" name="unidad">
                                <div class="row">
                                    <div class="col">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" required class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" name="nombre" required class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" name="apellido" class="form-control">
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Agregar</button>
                            </form>
                            <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancelar
                            </button>
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
    document.getElementById('btn_elimina_unidad').addEventListener('click', function() {
        var unidadId = this.getAttribute('data-unidad'); // Get the unidad_id from data attribute

        // Trigger SweetAlert2 confirmation
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará la unidad, las salas, usuarios, reservas, etc para la misma.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to elimina_unidad.php with the unidad parameter
                location.href = 'acciones/unidad_cambia.php?accion=elimina&unidad=' + unidadId;
            }
        });
    });
</script>
</body>

</html>
