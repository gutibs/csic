<?php
include("../login_check.php");
include("../../config/config.php");
include("../../clases/clase_csic.php");
$csic = new Csic();
$csic->storeFormValues($_POST);
$csic->editar_usuario();

header("location:../unidades.php");