<?php
include("../login_check.php");
include("../../config/config.php");
include("../../clases/clase_csic.php");
$csic = new Csic();
$csic->storeFormValues($_POST);

if($_POST['accion'] === "nuevo") {
    $csic->graba_nuevo_edificio();
}

if($_POST['accion'] === "edito") {
    $csic->edita_edificio();
}

if($_POST['accion'] === "elimina") {
    $csic->elimina_edificio();

}

header("location:../edificios.php");

