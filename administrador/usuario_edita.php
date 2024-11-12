<?php
include("login_check.php");
include("../config/config.php");
include("../clases/clase_csic.php");
$csic = new Csic();

if (!isset($_GET['usuario']) || !ctype_digit($_GET['usuario'])) {
    header("Location: error.php");
    exit;
}

$usuario_id = $_GET['usuario'];

$sql = "SELECT email, activo, nombre, apellido, rol, unidad FROM usuarios WHERE id = $usuario_id";
$usuario = $csic->get_this_1($sql);

$unidades = $csic->traer_unidades();

$roles = $csic->traer_roles();
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
                        <div class="d-flex justify-content-between mb-5">
                            <form action="acciones/usuario_edita_graba.php" method="post">
                                <!-- Hidden input for ID -->
                                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario_id) ?>">
                                <input type="hidden" name="unidad" value="<?= $_SESSION['unidad'] ?>">
                                <div class="row">

                                    <!-- Nombre -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="nombre">Nombre</label>
                                        <input class="form-control" id="nombre" name="nombre" type="text"
                                               value="<?= htmlspecialchars($usuario->nombre) ?>">
                                    </div>

                                    <!-- Apellido -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="apellido">Apellido</label>
                                        <input class="form-control" id="apellido" name="apellido" type="text"
                                               value="<?= htmlspecialchars($usuario->apellido) ?>">
                                    </div>

                                    <!-- Capacidad -->
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control" id="email" name="email" type="text"
                                               value="<?= htmlspecialchars($usuario->email) ?>">
                                    </div>

                                    <!-- Rol -->
                                    <div class="col-4 mb-3">
                                        <label for="rol" class="form-label">Rol</label>
                                        <select class="form-select" id="rol" name="rol" required>
                                            <option value=''>Seleccione</option>
                                            <?php
                                            foreach ($roles as $rol) {
                                                if ($usuario->rol === $rol->id) {
                                                    $sel = ' selected ';
                                                } else {
                                                    $sel = '';
                                                }
                                                echo "<option {$sel} value='{$rol->id}'>{$rol->rol}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Activo -->
                                    <div class="col-4 mb-3">
                                        <label for="activo" class="form-label">Estado</label>
                                        <select class="form-select" id="activo" name="activo" required>
                                            <option value=''>Seleccione</option>
                                            <?php
                                            foreach ($roles as $rol) {
                                                if ($usuario->activo === 1) {
                                                    echo "<option selected value='1'>Activo</option>";
                                                    echo "<option  value='0'>Inactivo</option>";
                                                } else {
                                                    echo "<option  value='1'>Activo</option>";
                                                    echo "<option selected value='0'>Inactivo</option>";
                                                }

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
                                <button class="btn btn-danger" role="button" type="button" id="btn_elimina_usuario" data-usuario="<?php echo $usuario_id; ?>">Eliminar</button>
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
    document.getElementById('btn_elimina_usuario').addEventListener('click', function () {
        var usuario = this.getAttribute('data-usuario');

        // Trigger SweetAlert2 confirmation
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará al usuario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = 'acciones/usuario_elimina.php?accion=elimina&usuario=' + usuario;
            }
        });
    });
</script>
</body>

</html>
