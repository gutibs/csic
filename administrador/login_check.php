<?php
session_start();

if (
    isset($_SESSION['logueado'], $_SESSION['rol'], $_SESSION['activo']) &&
    $_SESSION['logueado'] == 1 &&
    $_SESSION['rol'] == 2 &&
    $_SESSION['activo'] == 1
) {} else {
    // Destroy the session and redirect to index
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../ingreso.php");
    exit();
}
