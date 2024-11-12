<?php
include("../login_check.php");
include("../../config/config.php");
include("../../clases/clase_csic.php");
$csic = new Csic();

extract($_GET);
$sql = "DELETE FROM usuarios WHERE id = $usuario";
$csic->do_this($sql);

header("location:../unidades.php");