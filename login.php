<?php
session_start();
include("config/config.php");
include("clases/clase_csic.php");
$of = new Csic();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = "CSRF token invalido.";
    }
    if (empty($_POST['email'])) {
        $errors[] = "Correo electrónico es requerido.";
    } else {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Correo electrónico no es válido.";
        }
    }
    if (empty($_POST['password'])) {
        $errors[] = "Clave es requerida.";
    } else {
        $password = $_POST['password'];
    }

    if (!empty($_POST['reservante_completo'])) {
        $errors[] = "Gracias.";
    }

    if (empty($errors)) {
        $of->storeFormValues($_POST);
        $usuario = $of->login_reservante();
        if ($usuario === 1) {
            header("Location: index.php");
        } else {
            $errors[] = "Algun error";
            $_SESSION['login_errors'] = $errors;
            header("Location: index.php#ingreso");
        }
    } else {
        $_SESSION['login_errors'] = $errors;
        header("Location: index.php#ingreso");
    }
}
