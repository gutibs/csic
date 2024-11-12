<?php
include("../login_check.php");
include("../../config/config.php");
include("../../clases/clase_csic.php");
$csic = new Csic();


if($_POST['accion'] === "nueva") {
    $csic->storeFormValues($_POST);
    $csic->graba_nueva_unidad();
    header("location:../unidades.php");
}

if($_POST['accion'] === "edita") {
    $csic->storeFormValues($_POST);
    $csic->edita_unidad();
    header("location:../unidades.php");
}

if($_GET['accion'] === "elimina") {
    $csic->storeFormValues($_GET);
    $csic->elimina_unidad();
    header("location:../unidades.php");
}



