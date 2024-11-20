<?php
session_start();
include("../config/config.php");
include("../clases/clase_csic.php");
$of = new Csic();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors['csrf'] = "CSRF token invalido.";
    }
    if (empty($_POST['email'])) {
        $errors['email'] = "Correo electrónico es requerido.";
    } else {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Correo electrónico no es válido.";
        }
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Clave es requerida.";
    } elseif (strlen($_POST['password']) < 8) {
        $errors['password'] = "La clave debe tener al menos 8 caracteres.";
    } else {
        $password = $_POST['password'];
    }
    if (empty($errors)) {
        $of->storeFormValues($_POST);
        $usuario = $of->login_usuario();




        if($usuario === 1) {
            switch ((int)$_SESSION["rol"]) {
                case 1:
                    header("Location: ../master_admin/dashboard.php"); // Redirect to a protected page (e.g., dashboard)
                    exit;
                case 2:
                    header("Location: ../administrador/dashboard.php"); // Redirect for role 2
                    exit;
                case 3:
                    header("Location: ../guest_dashboard.php"); // Redirect for role 3
                    exit;
                default:
                    header("Location: ../error.php"); // Redirect for undefined roles
                    exit;
            }
        } else {
            $_SESSION['login_errors'] = "Algun error";
            header("Location: index.php");
        }
    } else {
        $_SESSION['login_errors'] = $errors;
        header("Location: index.php");
    }
}
