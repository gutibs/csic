<?php
session_start();
include("config/config.php");
include("clases/clase_csic.php");
$csic = new Csic();


$error = 0;

if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf'])) {
    $_SESSION['mensaje_success'] = "Gracias! hemos recibido su solicitud.";
    $error = 1;
}

// CSRF Token Validation
$csrf = $_POST['csrf'] ?? '';
if (!ctype_xdigit($csrf) || strlen($csrf) !== 64) {
    $_SESSION['mensaje_success'] = "Gracias! hemos recibido su solicitud.";
    $error = 1;
}

$nombre_completo = trim($_POST['nombre_completo'] ?? '');
if ( strlen($nombre_completo) >= 1) {
    $_SESSION['mensaje_success'] = "Gracias! hemos recibido su solicitud.";
    $error = 1;
}


$nombre = trim($_POST['nombre'] ?? '');
$nombre = filter_var($nombre, FILTER_SANITIZE_STRING);

$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensaje_error'] = "El campo email no puede estar vacio.";
    $error = 1;
}

$sala = $_POST['sala'] ?? '';
if (!filter_var($sala, FILTER_VALIDATE_INT)) {
    $_SESSION['mensaje_error'] = "Debe seleccionar una sala.";
    $error = 1;
}

// Message
$message = trim($_POST['message'] ?? '');
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

if($message === ''){
    $_SESSION['mensaje_error'] = "Debe especificar la solicitud.";
    $error = 1;
}

if($error === 1){
    header("location:index.php");
    exit;
}


$dsn = 'mysql:host=your_host;dbname=your_db;charset=utf8mb4';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Prepare an SQL statement
    $stmt = $pdo->prepare('INSERT INTO your_table (nombre_completo, nombre, email, sala, message) VALUES (:nombre_completo, :nombre, :email, :sala, :message)');

    // Bind parameters
    $stmt->bindParam(':nombre_completo', $nombre_completo);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sala', $sala, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message);

    // Execute the statement
    $stmt->execute();

    echo 'Data inserted successfully.';
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
